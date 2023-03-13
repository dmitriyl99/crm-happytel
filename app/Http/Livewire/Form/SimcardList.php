<?php

namespace App\Http\Livewire\Form;

use App\Models\Simcard;
use App\Models\Plan;
use App\Models\RegionGroup;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use Session;

class SimcardList extends Component
{
    protected $listeners = [
        'add-simcard' => 'addSimcard'
    ];
    
    public function addSimcard($data)
    {
      
        $region_group = RegionGroup::where('id',$data['region_group_id'])->first();
        $plan = Plan::where('id',$data['plan_id'])->first();
        $simcard = Simcard::where('id',$data['simcard_id'])->first();
        
        $simcards = session('simcards') ?? [];
        $newSimcards[$simcard->ssid] = ['region'=> $region_group, 'plan'=> $plan,'simcard' => $simcard];

        session(['simcards' => array_merge($simcards,$newSimcards)]);
        
        
    }
    
    public function removeSimcard($key)
    {
        $simcards = session('simcards');
        unset($simcards[$key]);
        session(['simcards' => $simcards]);
    }


    public function mount()
    {
        request()->session('simcards')->forget('simcards');
      
    }
    

    public function render()
    {
        return view('livewire.form.simcard-list');
    }
}
