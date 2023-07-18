<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductIncomeRequest;
use App\Models\Listproduct;
use App\Http\Requests\ListproductRequest;
use App\Models\ProductIncome;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;


class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $productIncomeQuery = ProductIncome::query();

        if($request->key){
            $productIncomeQuery->whereHas('product', function ($query) use ($request) {
                $query->where('name','like','%'.$request->key.'%')
                    ->orWhere('desc','like','%'.$request->key.'%')
                    ->orWhere('barcode','like','%'.$request->key.'%');
            });
        }

        $productIncomes = $productIncomeQuery
            ->with('product')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.warehouse.index', compact('productIncomes'));
    }
    public function create()
    {
        $products = Listproduct::query()->get();
        return view('admin.warehouse.create', compact('products'));
    }


    public function edit($id)
    {
        $listproduct = Listproduct::findOrFail($id);
        return view('admin.warehouse.edit', compact('listproduct'));
    }


    public function destroy($id)
    {
        $listproduct = ProductIncome::findOrFail($id);
        $listproduct->delete();
        return redirect()->route('admin.warehouse.index')->with(['success' => 'Удалено!']);
    }

    /**
     * @param ListproductRequest $request
     * @param $id
     * @return RedirectResponse
     * @throws NotFoundException
     */
    public function update(ProductIncomeRequest $request, $id): RedirectResponse
    {
        /** @var ProductIncome|null $listproduct */
        $productIncome = ProductIncome::query()->find($id);
        if ($productIncome === null) {
            throw new NotFoundException("Оприходование продукта не найдено");
        }
        $productIncome->update([
            'purchase_price_uzs' => $request->price_1,
            'selling_price_uzs' => $request->price_2,
            'selling_price_usd' => $request->price_3,
            'count' => $request->count,
            'barcode' => $request->barcode,
        ]);
        if ($barcode = $request->input('barcode')) {
            $listproduct->barcode = $barcode;
            $listproduct->save();
        }
        return redirect()->route('admin.warehouse.edit', $id)->with(['success' => 'Успешно обновлено']);
    }

    public function store(ProductIncomeRequest $request)
    {
        $product = Listproduct::query()
            ->where('name', $request->input('name'))
            ->first();

        if (!$product) {
            /** @var Listproduct $product */
            $product = Listproduct::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'price_1' => $request->price_1,
                'price_2' => $request->price_2,
                'price_3' => $request->price_3,
                'count' => $request->count,
                'created_at' => now()
            ]);
            if ($barcode = $request->input('barcode')) {
                $product->barcode = $barcode;
                $product->save();
            }
        }

        $product_income = new ProductIncome();
        $product_income->product_id = $product->id;
        $product_income->count = $request->input('count');
        $product_income->barcode = $product->barcode;
        $product_income->purchase_price_uzs = $product->price_1;
        $product_income->selling_price_usd = $product->price_2;
        $product_income->selling_price_uzs = $product->price_3;
        $product_income->created_at = now();
        $product_income->updated_at = now();
        $product_income->save();

        return redirect()->route('admin.warehouse.index')->with(['success' => 'Successfully created!']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file']
        ]);
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->path());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = array_slice($sheet->toArray(), 1);
        foreach ($rows as $row) {
            if ($row[0] == null) {
                continue;
            }

            $product = Listproduct::query()
                ->where('name', $row[0])
                ->first();
            if (!$product) {
                $product = new Listproduct();
                $product->name = $row[0];
                $product->desc = $row[1];
                $product->count = $row[2];
                $product->price_1 = $row[3];
                $product->price_2 = $row[5];
                $product->price_3 = $row[4];
                $product->barcode = $row[6];
                $product->save();
            }

            $product_income = new ProductIncome();
            $product_income->product_id = $product->id;
            $product_income->count = $row[2];
            $product_income->barcode = $row[6];
            $product_income->purchase_price_uzs = $row[3];
            $product_income->selling_price_usd = $row[5];
            $product_income->selling_price_uzs = $row[4];
            $product_income->created_at = now();
            $product_income->updated_at = now();
            $product_income->save();
        }
        return redirect()->route('admin.warehouse.index')->with(['success' => 'Successfully imported!']);
    }
}
