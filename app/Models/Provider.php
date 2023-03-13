<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function payments()
    {
        return $this->hasMany(PaymentActionProvider::class,'id','provder_id');
    }
}
