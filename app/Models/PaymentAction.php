<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAction extends Model
{
    use HasFactory;

    public $table = "payment_actions";
    protected $guarded = ['id'];

    public function agent()
    {
        return $this->hasOne(Agent::class,'id','agent_id');
    }
    
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function simcard()
    {
        return $this->hasOne(Simcard::class,'id','simcard_id');
    }

    public function application()
    {
        return $this->hasOne(Application::class,'id','application_id');
    }



}
