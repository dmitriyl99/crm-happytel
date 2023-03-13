<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Agent;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        
        $users = User::with('agent')->paginate(100);
        return view('admin.user.index',compact('users'));
    }

    public function create()
    {
        $agents = Agent::all();
        return view('admin.user.create',compact('agents'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'agent_id' => $request->agent_id
        ]);

        return redirect()->route('admin.user.index')->with(['success' => 'Successfully created!']);
    }

    public function edit($id)
    {
        $user = User::where('id',$id)->with('roles')->first();
        $agents = Agent::all();
        return view('admin.user.edit',compact('user','agents'));
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $fields = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'agent_id' => $request->agent_id
        ];
        if($request->password){
            $fields['password'] =  Hash::make($request->password);
        }
        $user->update($fields);
        return back()->with(['success' => 'Successfully updated!']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with(['success' => 'Successfully deleted!']);
    }
}
