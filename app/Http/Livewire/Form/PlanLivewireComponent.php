<?php

namespace App\Http\Livewire\Form;

use App\Models\Plan;
use Livewire\Component;

class PlanLivewireComponent extends Component
{
    protected $listeners = ['getPlans'];

    public $dropmenu = false;
    public $plans = [];
    public $plan;
    public $planId ;
    public $regionId;

    public function mount($planId)
    {
        if($planId){
            $plan = Plan::where('id',$planId)->first();
            $this->regionId = $plan->region_id;
            $this->plans = Plan::where('region_id',$this->regionId)->get();
            $this->plan = $plan->name;
            $this->planId = $planId;
        }
    }

    public function render()
    {
        return view('livewire.form.plan-livewire-component');
    }
    public function updatedPlan()
    {
        $this->plans = Plan::where('region_id',$this->regionId)->where('name','like',"%{$this->plan}%")->get();
        
    }

    public function getPlans($data)
    {
        if($data){
            $this->planId = '';
            $this->plan = '';
            $this->regionId = $data['regionId'];
            return $this->plans = Plan::where('status','active')->where('region_id',$data['regionId'])->get();
        }
    }

    public function selectedItem($id,$name)
    {
        $this->planId = $id;
        $this->plan = $name;
        $this->dropmenu = false;
        $this->emit('getSimcard',['plan_id' => $this->planId]);
    }
}
