<?php

namespace App\Http\Livewire\Form;

use App\Models\Simcard;
use App\Models\Plan;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class SimcardLivewireComponent extends Component
{
    protected $listeners = [
        'selecetedCountryUpdated' => 'getSimcards',
        'regionSelected' =>  'getSimcards',
        'region_group_id_changed' => 'region_group_id_changed',
        'add-simcard' => 'resetData'
    ];

    public $dropmenu = false;
    public $simcards = [];
    public $simcard;
    public $selectedSimcard = [];
    public $region_group_id = '';

    public function mount($simcardId,$regionId)
    {
        if($regionId){
            $this->simcards = Simcard:: where([
                'status' => 'inactive',
                'agent_id' => auth()->user()->agetn_id,
            ])->whereHas('regions',function($query) use($regionId){
                $query->where('id', $regionId);
            })->get();
        }
        
        if($simcardId){
            $this->selectedSimcard = Simcard::where('id',$simcardId)->first();
        }
       
    }
    
    public function resetData()
    {
        $this->dropmenu = false;
        $this->simcards = [];
        $this->simcard = '';
        $this->selectedSimcard = [];
    }
    
    
    public function region_group_id_changed($id)
    {
        $this->region_group_id = $id;
        $this->simcards = Simcard::whereHas('region_groups',function($query){
            $query->where('id',$this->region_group_id);
        })->where('agent_id', auth()->user()->agent->id)->get();
    }
    
    public function updatedSimcard()
    {
        if(!$this->simcard){
            return false;
        }
        $this->simcards = Simcard::where(function($query){
            $query->where('agent_id', auth()->user()->agent->id);
            if($this->simcard){
                $query->where('ssid', 'like', "%{$this->simcard}%");
            }
        })->whereHas('region_groups', function($query){
            $query->where('id',$this->region_group_id);
        })->get();
    }
    
    public function getSimcards($data)
    {
        $this->simcards = Simcard::whereHas('regions',function($query) use($data){
            $query->where('id',$data['regionId']);
        })->where('agent_id', auth()->user()->agent->id)->get();
    }



    public function selectedItem($id)
    {
        $this->selectedSimcard = Simcard::where('id',$id)->with('regions')->first();
        $this->emit('simcardSelected',['regions' => $this->selectedSimcard->regions]);
    }

    public function removeSimcardFromSelected($id)
    {
        $this->selectedSimcard = [];
        $this->emit('selectedSimcardCleared');
    }

    public function render()
    {
        return view('livewire.form.simcard-livewire-component');
    }
}
