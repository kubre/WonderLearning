<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;

class ReceiptModeListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'payment_mode'
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncPaymentMode';

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [
            Layout::rows([
                Input::make('bank_name')
                    ->canSee($this->query->has('b'))
                    ->tabindex(5)
                    ->title('Bank Name'),
                Input::make('bank_branch')
                    ->canSee($this->query->has('b'))
                    ->tabindex(6)
                    ->title('Bank Branch'),
                Input::make('transaction_no')
                    ->canSee($this->query->has('b'))
                    ->tabindex(7)
                    ->title('Cheque No'),
                DateTimer::make('paid_at')
                    ->canSee($this->query->has('b'))
                    ->tabindex(8)
                    ->title('Cheque Date')
                    ->format('Y-m-d')
                    ->enableTime(false),

                Input::make('transaction_no')
                    ->canSee($this->query->has('o'))
                    ->tabindex(9)
                    ->title('Transaction No'),
                DateTimer::make('paid_at')
                    ->canSee($this->query->has('o'))
                    ->tabindex(10)
                    ->title('Online Payment Date')
                    ->format('Y-m-d')
                    ->enableTime(false),
            ]),
        ];
    }
}
