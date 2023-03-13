<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $table = 'notification';

    protected $guarded = ['id'];

    public function agent()
    {
        return $this->hasOne('App\Models\Agent','id','agent_id');
    }

    public function application()
    {
        return $this->hasOne('App\Models\Application','id','application');
    }
}
