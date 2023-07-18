<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Warehouse.
 * @property int $id
 * @property int $count
 * @property int $product_id
 * @property Listproduct $product
 * @property ProductIncome $productIncome
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Warehouse extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = 'warehouse';

    public function productIncome(): BelongsTo
    {
        return $this->belongsTo(ProductIncome::class, 'product_income_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Listproduct::class, 'product_id', 'id');
    }
}
