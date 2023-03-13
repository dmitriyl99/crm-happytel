<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function update(Request $request)
    {
        session()->put($request->table,array_keys($request->column));

        return back()->with(['success' => 'Updated']);
    }
}
