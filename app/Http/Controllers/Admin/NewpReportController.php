<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SalesReportExport;
use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\Newp;
use App\Models\Listproduct;
use App\Exports\NewpExport;
use Maatwebsite\Excel\Facades\Excel;
class NewpReportController extends Controller
{
    public function reportIndex(Request $request)
    {
        $productsQuery = Listproduct::query()->select()->orderByDesc('created_at');
        if ($request->has('excel')) {
            return Excel::download(new SalesReportExport($productsQuery->get()), 'Отчёт по продажам.xlsx');
        }
        $products = $productsQuery->paginate();
        /** @var Listproduct $product */
        foreach ($products as $product)
        {
            $newpsCount = Newp::query()->where('product_id', $product->id)->count();
            $product->sales_count = $newpsCount;
            $product->sales_amount = $product->price_3 * $newpsCount;

            $warehouseCount = Warehouse::query()->where('product_id')->sum('count');
            $product->warehouse_count = $warehouseCount;
            $product->warehouse_amount = $product->price_3 * $warehouseCount;
        }
        return view('admin.newp.salesReport', compact('products'));
    }
}
