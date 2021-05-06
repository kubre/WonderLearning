<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\Receipt;
use App\Models\SchoolSyllabus;

class ApprovalService
{

    /** Checks whether approval is valid if is valid then initiates proper approval process */
    public function handle(Approval $approval): bool
    {
        if (!$this->canApprove($approval->approval_type, $approval->method)) {
            return false;
        }

        $entity = $approval->approval_type::find($approval->approval_id);

        if (is_null($entity)) {
            return false;
        }

        $this->{$approval->method}($entity, $approval->data);

        $approval->delete();

        return true;
    }

    public function canApprove(string $model, string $method): bool
    {
        return class_exists($model) && method_exists($this, $method);
    }

    /** @return bool|null */
    public function cancel(Approval $approval)
    {
        return $approval->delete();
    }

    public static function messageFor(Approval $approval): string
    {
        if ($approval->approval_type === Receipt::class) {
            return "Delete receipt for {$approval->approval->admission->student->name}. Receipt No: {$approval->approval->receipt_no} for amount {$approval->approval->amount}?";
        }
        if ($approval->approval_type === SchoolSyllabus::class) {
            return "Approve topic \"{$approval->approval->syllabus->name}\" marked completed by \"{$approval->data['teacher_name']}\" on date \"{$approval->data['completed_at']}\".";
        }
        return 'Nothing...';
    }

    /** Approval process for receipt deletion */
    private function deleteReceipt(Receipt $receipt, $data): void
    {
        if ($receipt->for === Receipt::SCHOOL_FEES) {
            (new InstallmentService())->restore(
                $receipt->amount,
                $receipt->admission_id
            );
        }

        $receipt->delete();
    }

    private function markSyllabus(SchoolSyllabus $covered, array $data)
    {
        $covered->fill([
            'completed_at' => $data['completed_at'],
        ])->save();
    }
}
