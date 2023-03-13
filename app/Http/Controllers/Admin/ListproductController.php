<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listproduct;
use App\Models\Newp;
use App\Http\Requests\ListproductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ListproductController extends Controller
{
    public function index()
    {
        $listproduct = Listproduct::query()->paginate(10);
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



    public function update(ListproductRequest $request, $id)
    {
        $listproduct = Listproduct::findOrFail($id)->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'price_1' => $request->price_1,
            'price_2' => $request->price_2,
            'price_3' => $request->price_3,
            'count' => $request->count
        ]);
        return redirect()->route('admin.listproduct.edit', $id)->with(['success' => 'Успешно обновлено']);
    }

    public function store(ListproductRequest $request)
    {
        $list = Listproduct::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'price_1' => $request->price_1,
            'price_2' => $request->price_2,
            'price_3' => $request->price_3,
            'count' => $request->count,
            'created_at' => now()
        ]);

        return redirect()->route('admin.listproduct.index')->with(['success' => 'Successfully created!']);
    }
}
