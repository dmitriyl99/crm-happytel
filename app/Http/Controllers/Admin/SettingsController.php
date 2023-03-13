<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function editStatus()
    {
        return view('admin.status');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'buy_simcard' => 'required',
//             'refound' => 'required',
//             'new_order' => 'required',
            'order_accepted' => 'required',
            'cancelled' => 'required',
            'added_other_plan' => 'required',
        ]);
        $arStatus = array (
            'buy_simcard' => $request->input('buy_simcard'),
//             'refound' =>  $request->input('refound'),
//             'new_order' =>  $request->input('new_order'),
            'order_accepted' =>  $request->input('order_accepted'),
            'cancelled' =>  $request->input('cancelled'),
            'added_other_plan' =>  $request->input('added_other_plan'),
            'balance_filled' =>  $request->input('balance_filled'),
          ) ;

          updateSettings('a_status',$arStatus);
          return back()->with(['success'=> 'Updated']);
    }

    public function editPaymentTypes()
    {
        $paymentTypes = Setting::where('type','payment_types')->get();
        return view('admin.payment_types',compact('paymentTypes'));
    }
    
    public function editGlobalSettings()
    {
        $settings = config('a_settings');
        return view('admin.settings',compact('settings'));
    }
    
    public function updateGlobalSettings()
    {
        request()->validate([
            'limit_balance' => 'required|numeric',
        ]);
        
        $arParams = [
            'limit_balance' => request()->limit_balance ?? 0
        ];
        
        updateSettings('a_settings',$arParams);
        return back()->with(['success'=> 'Updated']);
    }

    public function deletePaymentTypes ($id)
    {
        $setting = Setting::find($id);
        $setting->delete();
        return back();

    }

    public function storePaymentTypes (Request $request)
    {
        Setting::create([
            'key' => request()->itemKey,
            'value' => request()->itemValue,
            'type' => 'payment_types'
        ]);
        return back();
    }
}
