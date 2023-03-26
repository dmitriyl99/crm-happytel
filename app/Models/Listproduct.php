<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Listproduct.
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property string $price_1
 * @property string $price_2
 * @property string $price_3
 * @property Carbon $created_at
 * @property string $count
 * @property string $barcode
 */
class Listproduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = 'listproduct';


}
