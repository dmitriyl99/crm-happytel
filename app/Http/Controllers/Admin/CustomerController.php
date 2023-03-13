<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Helpers\FileUpload;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\UploadedFile;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $customers = Customer::where(function($query){
            if(auth()->user()->agent->id ?? false){
                $query->where('agent_id',auth()->user()->agent->id);
            }
        })->orderBy('id','ASC')->paginate(15);
        return view('admin.customer.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = Customer::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        if($request->file('passport')){
            $customer = Customer::findOrFail($customer->id);
            $customer->update([
                'passport' => FileUpload::handle($request->file('passport'),'passport')
            ]);
        }
        return redirect()->route('admin.customer.index')->with(['success' => 'Создано успешно']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::where('id',$id)->first();
        abort_if(!auth()->user()->isAdmin() && $customer->agent_id != auth()->user()->agent_id, 404);
        return view('admin.customer.edit',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        abort_if(!auth()->user()->isAdmin() && $customer->agent_id != auth()->user()->agent_id, 404);
        return view('admin.customer.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customerParams = [
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'status' => $request->status,
        ];
        if($request->file('passport')){
            $customerParams['passport'] = FileUpload::handle($request->file('passport'),'passport',$customer->passport);
        }
        $customer->update($customerParams);
        return redirect()->route('admin.customer.edit',$id)->with(['success' => 'Успешно обновлено']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update([
            'status' => 'inactive'
        ]);

        return redirect()->route('admin.customer.index')->with(['success' => 'Сделал неактивным!']);
    }
}
