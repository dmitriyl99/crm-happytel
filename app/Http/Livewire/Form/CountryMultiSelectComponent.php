<?php

namespace App\Http\Livewire\Form;

use App\Models\Region;
use Livewire\Component;

class CountryMultiSelectComponent extends Component
{
    public $dropmenu = false;
    public $items = [];
    public $item;
    public $itemIds;
    public $selectedItems = [];

    public function mount($itemIds)
    {
        $this->items = Region::all();

        $this->itemIds = $itemIds;
        if($this->itemIds){
            foreach($this->items as $item)
            {
                if(in_array($item->id, $itemIds)){
                    $this->selectedItems[$item->id] = $item->name;
                }
            }
        }
        
    }

    public function updatedItem()
    {
        $this->items = Region::where(function($query){
            if($this->item){
                $query->where('name', 'like', "%{$this->item}%");
            }
            
        })->get();
    }

    public function selectedItem($id,$name)
    {
        $this->item = '';
        $this->dropmenu = false;
        $this->selectedItems[$id] = $name; 
        $this->emit('selecetedCountryUpdated',['countries' => $this->selectedItems]);
    }

    public function removeItemFromSelected($id)
    {
        unset($this->selectedItems[$id]);
        $this->emit('selecetedCountryUpdated',['countries' => $this->selectedItems]);
    }

    public function render()
    {
        return view('livewire.form.country-multi-select-component');
    }


}
