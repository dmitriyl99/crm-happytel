<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Listproduct;
use App\Http\Requests\ListproductRequest;
use Illuminate\Http\RedirectResponse;


class ListproductController extends Controller
{
    public function index()
    {
        $listproduct = Listproduct::query()->orderByDesc('created_at')->paginate(10);
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
}
