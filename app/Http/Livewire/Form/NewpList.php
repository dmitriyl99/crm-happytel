<?php

namespace App\Http\Livewire\Form;

use App\Models\Listproduct;
use App\Models\Simcard;
use App\Models\Plan;
use App\Models\RegionGroup;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use Session;

class NewpList extends Component
{
    protected $listeners = [
        'add-product' => 'addProduct'
    ];
    
    public function addProduct($data)
    {
      
          
        $list = Listproduct::where('id',$data['product_id'])->first();
        $newp = session('newp') ?? [];
        $newSimcards[$data['count']] = ['products'=> $list->name,'count'=>$data['count'], 'product_id'=> $data['product_id']];

        session(['newp' => array_merge($newp,$newSimcards)]);
        
        
    }
    public function removeProduct($key)
    {
        $product = session('newp');
        unset($product[$key]);
        session(['newp' => $product]);
    }


    public function mount()
    {
        request()->session('newp')->forget('newp');
      
    }
    

    public function render()
    {
        return view('livewire.form.newp-list');
    }
}
