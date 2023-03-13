<?php

namespace App\Http\Livewire\Form;

use App\Models\Customer;
use Livewire\Component;

class NameLivewireComponent extends Component
{
    public $customerId;
    public $customer;
    public $customers = [];
    public $dropmenu = false;
    public $selectedCustomer;
    public $phone;

    public function mount($customerId,$full_name,$phone)
    {
        $this->customers = Customer::where('agent_id',auth()->user()->agent->id)->where('status','active')->limit(30)->get();
        if($customerId){
            $this->selectedCustomer = Customer::find($customerId)->toArray();
        }
        $this->customer = $full_name;
        $this->phone = $phone;
    }

    public function render()
    {
        return view('livewire.form.name-livewire-component');
    }
    public function updatedCustomer()
    {
        $customers = Customer::where('agent_id',auth()->user()->agent->id)->where('full_name','like', "%{$this->customer}%")->limit(30)->get();
        if($customers->count()){
            return $this->customers = $customers;
        }
        $this->customers = [];
    }
    public function selectedItem($item)
    {
        $this->dropmenu  = false;
        $this->selectedCustomer = $item;
  
    }

    public function resetAll()
    {
        $this->customerId = '';
        $this->selectedCustomer = false;
    }
}
