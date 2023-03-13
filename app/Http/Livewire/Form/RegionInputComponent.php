<?php

namespace App\Http\Livewire\Form;

use App\Models\Region;
use Livewire\Component;

class RegionInputComponent extends Component
{
    public $dropmenu = false;
    public $regions = [];
    public $region = "";
    public $regionId;
    public function mount($regionId)
    {
        $this->regions = Region::where('status','active')->get();
        if($regionId){
            $region = Region::find($regionId);
            $this->region = $region->name;
            $this->regionId = $regionId;
        }
        
    }
    public function render()
    {
        return view('livewire.form.region-input-component');
    }

    public function updatedRegion()
    {
        $this->dropmenu = true;
        $this->regions = Region::where('name','like',"%{$this->region}%")->get();
    }

    public function selectedRegion($id,$name)
    {
        $this->regionId = $id;
        $this->region = $name;
        $this->dropmenu = false;
        $this->emit('regionSelected',['regionId' => $this->regionId]);
    }
}
