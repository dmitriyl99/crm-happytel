<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::query()->paginate();
        return view('admin.permission.index',compact('permissions'));
    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(PermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
            'title' => $request->title,
            'guard_name' => 'web'
        ]);
        return redirect()->route('admin.permission.index')->with(['success' => 'Successfully created!']);
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permission.edit',compact('permission'));
    }

    public function update(PermissionRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
            'title' => $request->title,
        ]);

        return back()->with(['success' => 'Successfully updated!']);
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return back()->with(['success' => 'Successfully deleted!']);
    }
}
