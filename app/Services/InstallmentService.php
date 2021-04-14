<?php

namespace App\Services;

use App\Models\Installment;

class InstallmentService
{

    public function deduct(int $amount, int $admission_id): void
    {
        $installments = Installment::unpaid($admission_id)
            ->orderBy('id')
            ->get();

        foreach ($installments as $installment) {
            if ($installment->due_amount >= $amount) {
                $installment->due_amount -= $amount;
                $amount = 0;
            } else {
                $amount -= $installment->due_amount;
                $installment->due_amount = 0;
            }

            $installment->save();
            if (0 === $amount) break;
        }
    }

    public function restore(int $amount, int $admission_id): void
    {
        $installments = Installment::paid($admission_id)
            ->orderByDesc('id')
            ->get();

        foreach ($installments as $installment) {
            if ($installment->paid_amount >= $amount) {
                $installment->due_amount += $amount;
                $amount = 0;
            } else {
                $amount -= $installment->paid_amount;
                $installment->due_amount = $installment->amount;
            }

            $installment->save();
            if (0 === $amount) break;
        }
    }
}
