<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegionGroup;
use App\Http\Requests\RegionGroupRequest;

class RegionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = RegionGroup::query()->paginate(10);
        return view('admin.region_group.index',compact('entities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.region_group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionGroupRequest $request)
    {
        RegionGroup::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.region_group.index')->with(['success' => 'Создано успешно']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = RegionGroup::findOrFail($id);
        return view('admin.region_group.edit',compact('entity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegionGroupRequest $request, $id)
    {
        $entity = RegionGroup::findOrFail($id);
        $entity->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.region_group.edit',$id)->with(['success' => 'Успешно обновлено']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entity = RegionGroup::findOrFail($id);
        $entity->delete();
        return redirect()->route('admin.region_group.index')->with(['success' => 'Успешно удалено!']);
    }
}
