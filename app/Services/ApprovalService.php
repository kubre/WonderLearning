<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\Receipt;

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

        $this->{$approval->method}($entity);

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

    /** Approval process for receipt deletion */
    private function deleteReceipt(Receipt $receipt): void
    {
        if ($receipt->for === Receipt::SCHOOL_FEES) {
            (new InstallmentService())->restore(
                $receipt->amount,
                $receipt->admission_id
            );
        }

        $receipt->delete();
    }
}
