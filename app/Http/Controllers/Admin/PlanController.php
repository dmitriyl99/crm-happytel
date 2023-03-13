<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Models\Provider;
use App\Models\Region;
use App\Models\RegionGroup;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type = false)
    {
        $plans = Plan::where(function($query) use($type,$request){
            if($type){
                $query->where('type',$type);
            }else{
                $query->where('type','normal');
            }
            if(request()->key){
                $query->where('name','like','%'.request()->key.'%');
                
                $query->orwhereHas('regions', function($query){
                    $query->where('name','like','%'.request()->key.'%');
                    
                })->orWhereHas('region_group',function($query){
                    $query->where('name','like','%'.request()->key.'%');
                    
                });
            }
           
            
        })->orderBy('id','DESC')->with('regions','provider')->paginate(15);

        return view('admin.plan.index',compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $region_groups = RegionGroup::all();
        $regions = Region::all();
        $providers = Provider::all();
        return view('admin.plan.create',compact('regions','providers','region_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        $plan = Plan::create([
            'name' => $request->name,
            'status' => $request->status,
            'expiry_day' => $request->expiry_day,
            'quantity_minut' => $request->quantity_minut,
            'quantity_internet' => $request->quantity_internet,
            'traffic_type' => $request->traffic_type,
            'quantity_sms' => $request->quantity_sms,
            'price_arrival' => $request->price_arrival,
            'price_sell' => $request->price_sell,
            'price_user' => $request->price_user ?? 0,
            'type' => $request->type,
            'provider_id' => $request->provider_id,
            'region_group_id' => $request->region_group_id,
        ]);

        $plan->regions()->attach($request->regionIds);
        if($request->type == 'normal'){
            return redirect()->route('admin.plan.index')->with(['success' => 'Создано успешно']);
        }else{
            return redirect()->route('admin.additionally.plan','additional')->with(['success' => 'Создано успешно']);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::where('id',$id)->with('regions','provider')->first();
        $region_groups = RegionGroup::all();
        $providers = Provider::all();
        return view('admin.plan.edit',compact('plan','providers','region_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, $id)
    {
        $plan = Plan::findOrFail($id);
    
        $plan->update([
            'name' => $request->name,
            'status' => $request->status,
            'expiry_day' => $request->expiry_day,
            'quantity_minut' => $request->quantity_minut,
            'quantity_internet' => $request->quantity_internet,
            'traffic_type' => $request->traffic_type,
            'quantity_sms' => $request->quantity_sms,
            'price_arrival' => $request->price_arrival,
            'price_sell' => $request->price_sell,
            'price_user' => $request->price_user ?? 0,
            'type' => $request->type,
            'provider_id' => $request->provider_id,
            'region_group_id' => $request->region_group_id,
        ]);
        $plan->regions()->sync($request->regionIds);
        return redirect()->route('admin.plan.edit',$id)->with(['success' => 'Успешно обновлено']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return redirect()->route('admin.plan.index')->with(['success' => 'Успешно удалено!']);
    }
}
