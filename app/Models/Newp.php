<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Newp.
 * @property int $id
 * @property string $count
 * @property string $payment_type
 * @property int $product_id
 * @property Listproduct $listproduct
 * @property int $product_income_id
 * @property ProductIncome $productIncome
 * @property User $sold_by
 * @property string $customer_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
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

    public function productIncome()
    {
        return $this->hasOne(ProductIncome::class, 'id', 'product_income_id');
    }
}
