<?php

namespace App\Http\Livewire\Form;

use App\Models\Region;
use Livewire\Component;

class RegionLivewireComponent extends Component
{
    public $regions;
    public $regionId;

    public function mount($regionId)
    {
        $this->regions = Region::where('status','active')->get();
        $this->regionId = $regionId;
      
    }
    
    public function render()
    {
        return view('livewire.form.region-livewire-component');
    }

    public function updatedRegionId()
    {
        $this->emit('getPlans',['regionId' => $this->regionId]);
    }

}
