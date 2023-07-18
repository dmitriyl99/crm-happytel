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
 * @property int $purchase_price_uzs
 * @property int $selling_price_uzs
 * @property int $selling_price_usd
 * @property int $product_id
 * @property Listproduct $product
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ProductIncome extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = 'product_incomes';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Listproduct::class, 'product_id', 'id');
    }
}
