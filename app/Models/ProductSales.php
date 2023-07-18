<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductIncome.
 * @property int $id
 * @property int $count
 * @property string $barcode
 * @property int $selling_price_uzs
 * @property int $product_id
 * @property Listproduct $product
 * @property int $product_income_id
 * @property ProductIncome $productIncome
 * @property User $sold_by
 * @property int $sold_by_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ProductSales extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = 'product_incomes';

    public function productIncome(): BelongsTo
    {
        return $this->belongsTo(ProductIncome::class, 'product_income_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Listproduct::class, 'product_id', 'id');
    }

    public function soldBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sold_by_id', 'id');
    }
}
