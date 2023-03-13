<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Newp;
use Livewire\WithPagination;

class NewpList extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $product_id;
    public $filter = [
        'product_id' => '',
        'payment_type' => ''
    ];

    public function updatedKey()
    {
    }

    public function mount($product_id)
    {
        $this->product_id = $product_id;
        
        if(auth()->user()->isAdmin()){
            if(request()->product_id){
                $this->filter['product_id'] = request()->product_id;
            }
            if(request()->payment_type){
                $this->filter['payment_type'] = request()->payment_type;
            }
        }
        
        
    }

    public function render()
    {
        $newp= Newp::where(function ($query) {
            if($this->filter['product_id']){
                $query->where('product_id',$this->filter['product_id']);
            }
            if($this->filter['payment_type']){
                $query->where('payment_type',$this->filter['payment_type']);
            }
                       
        });

        return view('livewire.newp-list', ['newp' => $newp]);
    }
}
