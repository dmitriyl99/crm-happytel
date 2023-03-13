<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(\App\Models\User::class,'id','user_id');
    }

    public function users()
    {
        return $this->hasMany(\App\Models\User::class,'agent_id','id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification','agent_id','id');
    }

    public function paymentActions()
    {
        return $this->hasMany('App\Models\PaymentAction','agent_id','id');
    }

    public function simcards()
    {
        return $this->hasMany('App\Models\Simcard','agent_id','id');
    }

    public function activeSimcards()
    {
        return $this->hasMany('App\Models\Simcard','agent_id','id')->where('status','active');
    }

    public function inActiveSimcards()
    {
        return $this->hasMany('App\Models\Simcard','agent_id','id')->where('status','inactive');
    }
}
