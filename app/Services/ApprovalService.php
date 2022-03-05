<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\Receipt;
use App\Models\SchoolSyllabus;
use App\Models\Syllabus;

class ApprovalService
{

    /** Checks whether approval is valid if is valid then initiates proper approval process */
    public function handle(Approval $approval): bool
    {
        if (!$this->canApprove($approval->approval_type, $approval->method)) {
            return false;
        }

        $this->{$approval->method}($approval);

        $approval->delete();

        return true;
    }

    public function canApprove(string $model, string $method): bool
    {
        return class_exists($model) && method_exists($this, $method);
    }

    public function cancel(Approval $approval): ?bool
    {
        if ($approval->approval_type === Syllabus::class) {
            SchoolSyllabus::where('school_id', $approval->school_id)
                ->where('syllabus_id', $approval->approval_id)
                ->delete();
        }
        return $approval->delete();
    }

    public static function messageFor(Approval $approval): string
    {
        if ($approval->approval_type === Receipt::class) {
            return "Delete receipt for {$approval->approval->admission->student->name}. Receipt No: {$approval->approval->receipt_no} for amount {$approval->approval->amount}?";
        }
        if ($approval->approval_type === Syllabus::class) {
            return "Approve topic \"{$approval->approval->name}\" marked completed by \"{$approval->data['teacher_name']}\" on date \"{$approval->data['completed_at']}\".";
        }
        return 'Nothing...';
    }

    /** Approval process for receipt deletion */
    private function deleteReceipt(Approval $approval): void
    {
        if ($approval->approval->for === Receipt::SCHOOL_FEES) {
            (new InstallmentService())->restore(
                $approval->approval->amount,
                $approval->approval->admission_id
            );
        }

        $approval->approval->delete();
    }

    private function markSyllabus(Approval $approval): void
    {
        SchoolSyllabus::updateOrCreate([
            'school_id' => $approval->school_id,
            'syllabus_id' => $approval->approval_id,
        ], [
            'completed_at' => $approval->data['completed_at'],
        ]);
    }
}
