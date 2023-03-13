<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::query()->paginate();
        return view('admin.role.index',compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('admin.role.create',compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $role->assignPermissions($request->permissions);

        return redirect()->route('admin.role.index')->with(['success' => 'Successfully created!']);
    }

    public function edit($id)
    {
        $role = Role::where('id',$id)->with('permissions')->first();

        $permissions = Permission::all();
        return view('admin.role.edit',compact('role','permissions'));
    }

    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'title' => $request->title,
        ]);
        $role->syncPermissions($request->permissions);

        return back()->with(['success' => 'Successfully updated!']);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return back()->with(['success' => 'Successfully deleted!']);
    }
}
