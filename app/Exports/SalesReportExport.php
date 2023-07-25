<?php

namespace App\Exports;

use App\Models\Listproduct;
use App\Models\Newp;
use App\Models\Warehouse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesReportExport implements FromCollection
{
    /** @var Collection $products */
    private $products;
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $result = collect([
            ['', '', 'Продано', '', 'Остаток'],
            ['Номер', 'Название товара', 'Количество', 'Стоимость', 'Количество', 'Стоимость']
        ]);
        $products = collect();
        /**
         * @var int $key
         * @var Listproduct $product
         */
        foreach ($this->products as $key => $product)
        {
            $newpsCount = Newp::query()->where('product_id', $product->id)->count();
            $product->sales_count = $newpsCount;
            $product->sales_amount = $product->price_3 * $newpsCount;

            $warehouseCount = Warehouse::query()->where('product_id')->sum('count');
            $product->warehouse_count = $warehouseCount;
            $product->warehouse_amount = $product->price_3 * $warehouseCount;

            $products->push([
                $key + 1,
                $product->name,
                $product->sales_count != 0 ? $product->sales_count : "0",
                $product->sales_amount != 0 ? $product->sales_amount : "0",
                $product->warehouse_count != 0 ? $product->warehouse_count : "0",
                $product->warehouse_amount != 0 ? $product->warehouse_amount : "0"
            ]);
        }
        $result->push($products);
        return $result;
    }
}
