<?php

namespace App\Http\Livewire;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class PaymentTypeComponent extends Component
{
    public $paymentTypes = [];
    public $paymentKey = '';
    public $paymentValue = '';
    public $errorMessage = '';


    public function render()
    {
        $this->getPaymentTypes();
        return view('livewire.payment-type-component');
    }

    public function getPaymentTypes()
    {
        $this->paymentTypes = Setting::where('type','payment_types')->get();
    }

    public function removeItem($itemId)
    {
        $setting = Setting::where('id',$itemId)->first();
        $setting->delete();
        //$this->getPaymentTypes();
    }

    public function addNewItem()
    {
        Setting::create([
            'key' => $this->paymentKey,
            'value' => $this->paymentValue,
            'type' => 'payment_types'
        ]);
        $this->paymentKey = '';
        $this->paymentValue = '';
       // $this->getPaymentTypes();
        $this->errorMessage = '';
    }
}
