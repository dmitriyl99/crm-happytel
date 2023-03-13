<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'newp';

    public function listproduct()
    {
        return $this->hasOne(Listproduct::class, 'id', 'product_id');
    }
    public function setting()
    {
        return $this->hasOne(Setting::class, 'key', 'payment_type');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
