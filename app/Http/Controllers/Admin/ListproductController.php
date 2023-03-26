<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Listproduct;
use App\Http\Requests\ListproductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ListproductController extends Controller
{
    public function index(Request $request)
    {
        $listProductQuery = Listproduct::query();

        if($request->key){
            $listProductQuery->where('name','like','%'.$request->key.'%')
                ->orWhere('desc','like','%'.$request->key.'%')
                ->orWhere('barcode','like','%'.$request->key.'%');
        }

        $listproduct = $listProductQuery->orderByDesc('created_at')->paginate(10);
        return view('admin.listproduct.index', compact('listproduct'));
    }
    public function create()
    {
        return view('admin.listproduct.create');
    }


    public function edit($id)
    {
        $listproduct = Listproduct::findOrFail($id);
        return view('admin.listproduct.edit', compact('listproduct'));
    }


    public function destroy($id)
    {
        $listproduct = Listproduct::findOrFail($id);
        $listproduct->delete();
        return redirect()->route('admin.listproduct.index')->with(['success' => 'Удалено!']);
    }

    /**
     * @param ListproductRequest $request
     * @param $id
     * @return RedirectResponse
     * @throws NotFoundException
     */
    public function update(ListproductRequest $request, $id): RedirectResponse
    {
        /** @var Listproduct|null $listproduct */
        $listproduct = Listproduct::query()->find($id);
        if ($listproduct === null) {
            throw new NotFoundException("Продукт не найден");
        }
        $listproduct->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'price_1' => $request->price_1,
            'price_2' => $request->price_2,
            'price_3' => $request->price_3,
            'count' => $request->count
        ]);
        if ($barcode = $request->input('barcode')) {
            $listproduct->barcode = $barcode;
            $listproduct->save();
        }
        return redirect()->route('admin.listproduct.edit', $id)->with(['success' => 'Успешно обновлено']);
    }

    public function store(ListproductRequest $request)
    {
        /** @var Listproduct $list */
        $list = Listproduct::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'price_1' => $request->price_1,
            'price_2' => $request->price_2,
            'price_3' => $request->price_3,
            'count' => $request->count,
            'created_at' => now()
        ]);
        if ($barcode = $request->input('barcode')) {
            $list->barcode = $barcode;
            $list->save();
        }

        return redirect()->route('admin.listproduct.index')->with(['success' => 'Successfully created!']);
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
        return redirect()->route('admin.listproduct.index')->with(['success' => 'Successfully imported!']);
    }
}
