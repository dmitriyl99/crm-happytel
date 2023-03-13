<?php

namespace App\Http\Livewire\Form;

use App\Models\Plan;
use App\Models\Simcard;
use Livewire\Component;

class PlanComponent extends Component
{
    protected $listeners = [
//         'selectedSimcardCleared' => 'planClear',
        'region_group_id_changed' => 'getPlansByRegionGroupId',
        'add-simcard' => 'resetData'
    ];
    public $plans = [];
    public $planId = '';
    public $additional = false;

    public function mount($simcardId,$planId, $region_group_id = 0, $additional = false)
    {
        $this->additional = $additional;
     
        if($planId && $additional == false){
            $this->planId = $planId;
        }
        if($simcardId){
            $simcard = Simcard::where([
                'id' => $simcardId,
            ])->with('regions')->first();

            $regionIds = $simcard != null ? $simcard->regions->toArray() : [];
            $this->getPlans(['regions' => $regionIds]);
        }
        
        $this->getPlansByRegionGroupId($region_group_id);
    }
    
    public function resetData()
    {
        $this->plans = [];
        $this->planId = ''; 
    }
    
    public function getPlansByRegionGroupId($regionGroupId)
    {
//         if(auth()->user()->id == 1){
//             dd($regionGroupId);
//         }
        $this->plans = Plan::where(function($query) use($regionGroupId){
            $query->where('status','active');
            $query->where('region_group_id',$regionGroupId);
            if( $this->additional){
                $query->where('type','additional');
            }else{
                $query->where('type','normal');
            }
            
        })->get();
        
    }

    public function planClear()
    {
        $this->plans = [];
    }

    public function getPlans($data)
    {
        $regionIds = array_column($data['regions'],'id');
        $this->plans = Plan::where(function($query){
            $query->where('status','active');
            if(!$this->additional){
                $query->where('type','normal');
            }elseif($this->additional){
                $query->where('type','additional');
            }
        })->whereHas('regions', function($query) use($regionIds){
            $query->whereIn('id', $regionIds);
        })->with(['regions'])->get();
    }

    public function render()
    {
        return view('livewire.form.plan-component');
    }
}
