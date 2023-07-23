<?php

namespace App\Http\Livewire\Form;

use App\Models\Listproduct;
use Livewire\Component;

class BarcodeLivewireComponent extends Component
{
    public $barcode;
    public function render()
    {
        return view('livewire.form.barcode-livewire-component');
    }

    public function updatedBarcode()
    {
        /** @var Listproduct $product */
        $product = Listproduct::query()->where('barcode', $this->barcode)->first();
        if ($product !== null) {
            $this->emit('add-product', [
                'product_id' => $product->id,
                'count' => 1
            ]);
            $this->barcode = '';
        }
    }
}
