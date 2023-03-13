<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\PaymentAction;

use App\Http\Requests\ProviderRequest;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Provider::orderBy('id','ASC')->paginate(15);
        return view('admin.provider.index',compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.provider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderRequest $request)
    {
        $provider = Provider::create([
            'name' => $request->name,
            'contract_number' => $request->contract_number,
            'contract_date' => $request->contract_date,
        ]);

        if($request->input('payment')){
            $fee = str_replace(' ','',$request->input('payment'));
            $provider->update([
                'balance' => $provider->balance ?  $provider->balance +  $fee :  $fee
            ]);
        }
        return redirect()->route('admin.provider.index')->with(['success' => 'Создано успешно']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provider = Provider::where('id',$id)->with(['applications','applications.simcards'])->first();
        return view('admin.provider.show',compact('provider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provider = Provider::findOrFail($id);
        return view('admin.provider.edit',compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderRequest $request, $id)
    {
        $provider = Provider::findOrFail($id);
        $providerParams = [
            'name' => $request->name,
            'contract_number' => $request->contract_number,
            'contract_date' => $request->contract_date,
        ];
        if($request->input('payment')){
            $fee = str_replace(' ','',$request->input('payment'));
            $providerParams['balance'] = $provider->balance ?  $provider->balance + $fee : $fee;
        }
      
        $provider->update($providerParams);
        return redirect()->route('admin.provider.edit',$id)->with(['success' => 'Успешно обновлено']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();

        return redirect()->route('admin.provider.index')->with(['success' => 'Сделал неактивным!']);
    }
    
    public function pay()
    {
        request()->validate([
            'sum' => 'required',
            'provider_id' => 'required',
            'payment_date' => 'required',
        ]);
        
        
        $fee = str_replace(' ','',request()->sum);
        $provider = Provider::findOrFail(request()->provider_id);
        $provider->update([
            'balance' => $provider->balance ? $provider->balance + $fee : $fee
        ]);
        
        PaymentAction::create([
            'fee' => $fee,
            'provider_id' => $provider->id,
            'message' => config('a_status.balance_filled', 'Баланс заполнен'),
            'type' => 'entry',
            'action' => 'provider',
            'created_at' => request()->payment_date,
            'user_id' => auth()->user()->id
        ]);
        return back()->with(['success' => 'Успешно обновлено']);
    }
    
    
}
