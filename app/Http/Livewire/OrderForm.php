<?php

namespace App\Http\Livewire;

use Livewire\Component;

class OrderForm extends Component
{
    public $countSimcard = 1;
    public function render()
    {
        return view('livewire.order-form');
    }

    public function increamentSimcard()
    {
        return $this->countSimcard = $this->countSimcard + 1;
    }
}
