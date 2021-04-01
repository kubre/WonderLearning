<?php

namespace App\View\Components;

use App\Models\Admission;
use Illuminate\View\Component;

class AdmissionReceipt extends Component
{

    private ?Admission $admission = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Admission $admission)
    {
        $this->admission = $admission;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admission-receipt', ['admission' => $this->admission]);
    }
}
