<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }
    public function region_group()
    {
        return $this->hasOne(RegionGroup::class, 'id', 'region_group_id');
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }
    
    public function provider()
    {
        return $this->hasOne(Provider::class, 'id', 'provider_id');
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function agent()
    {
        return $this->hasOne(Agent::class, 'id', 'agent_id');
    }

    public function simcard()
    {
        return $this->hasOne(Simcard::class, 'id', 'simcard_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
