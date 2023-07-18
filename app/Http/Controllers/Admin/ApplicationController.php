<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequest;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ApplicationSimcard;
use App\Models\Customer;
use App\Models\Region;
use App\Models\RegionGroup;
use App\Models\Agent;
use App\Models\Plan;
use Carbon\Carbon;
use App\Models\Simcard;
use App\Models\PaymentAction;
use App\Models\User;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $status)
    {
        $regions = Region::all();
        $agents = Agent::all();
        $plans = Plan::all();
        $users = User::all();

        return view('admin.application.index', compact('regions', 'plans', 'agents', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::where('status', 'active')->get();
        $region_groups = RegionGroup::all();
        return view('admin.application.create', compact('regions', 'region_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        //         request()->validate([
        //             'simcards.*' => 'required',
        //             'plans.*' => 'required',
        //             'region_groups.*' => 'required',
        //         ]);

        if (!$request->customer_id) {
            $customer = Customer::create([
                'full_name' => $request->full_name ?? '',
                'phone' => str_replace(['+', ' ',], '', $request->phone ?? ''),
                'ticket' => $request->ticket ?? '',
                'status' => 'active',
                'agent_id' => auth()->user()->agent->id ?? ''
            ]);

            if ($request->file('passport')) {
                $customer = Customer::findOrFail($customer->id);
                $customer->update([
                    'passport' => FileUpload::handle($request->file('passport'), 'passport')
                ]);
            }
        }

        foreach ($request->region_groups as $key => $item) {
            Application::create([
                'simcard_id' => $request->simcards[$key],
                'plan_id' => $request->plans[$key],
                'agent_id' => auth()->user()->agent->id ?? '',
                'date_start' => date('Y-m-d H:i:s', strtotime($request->date_start)),
                'date_finish' => date('Y-m-d H:i:s', strtotime($request->date_finish)),
                'customer_id' => $request->customer_id ?? $customer->id,
                'status' => $request->status,
                'payment_type' => $request->payment_type,
                'region_group_id' => $item,
                'user_id' => auth()->user()->id,
            ]);
        }

        if (session()->get('error')) {
            return back()->withInput();
        }
        return redirect()->route('admin.application.index', $request->status)->with(['success' => 'Создано успешно']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $regions = Region::where('status', 'active')->get();
        $application = Application::findOrFail($id);
        abort_if(!auth()->user()->isAdmin() && auth()->user()->agent_id != $application->agent_id, 404);

        return view('admin.application.show', compact('regions', 'application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regions = Region::where('status', 'active')->get();
        $region_groups = RegionGroup::all();
        $application = Application::findOrFail($id);
        if (!auth()->user()->isAdmin() && $application->agent_id != auth()->user()->agent->id) {
            return abort(404);
        }
        return view('admin.application.edit', compact('regions', 'application', 'region_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'region_group_id' => 'required',
            'plan_id' => 'required',
            'simcard_id' => 'required',
            'payment_type' => 'required'
        ]);

        if (!$request->customer_id) {
            $customer = Customer::create([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'status' => 'active',
                'agent_id' => auth()->user()->agent->id ?? ''
            ]);

            if ($request->file('passport')) {
                $customer = Customer::findOrFail($customer->id);
                $customer->update([
                    'passport' => FileUpload::handle($request->file('passport'), 'passport')
                ]);
            }
        }


        $params = [
            'region_id' => $request->region_id,
            'simcard_id' => $request->simcard_id,
            'plan_id' => $request->plan_id,
            'date_start' => date('Y-m-d H:i:s', strtotime($request->date_start)),
            'date_finish' => date('Y-m-d H:i:s', strtotime($request->date_finish)),
            'customer_id' => (int)$request->customer_id ?? $customer->id,
            'payment_type' => $request->payment_type,
            'region_group_id' => $request->region_group_id,
            //             'user_id' => auth()->user()->id,
        ];
        if ($request->status == 'additional') {
            $params['status'] = 'additional';
        }

        $application = Application::findOrFail($id);
        $application->update($params);
        return back()->with(['success' => 'Успешно обновлено']);
    }

    public function addPlan($id)
    {
        $application = Application::findOrFail($id);

        abort_if($application->agent_id != auth()->user()->agent_id, 404);


        return view('admin.add-plan', compact('application'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        if ($agentId = auth()->user()->agent->id) {
            if ($application->agent_id != $agentId) {
                return abort(404);
            }
        }
        $application->delete();

        $paymentActions = PaymentAction::where('application_id', $id)->get();
        foreach ($paymentActions as $item) {
            $item->delete();
        }


        return back()->with(['success' => 'Успешно удалено!']);
    }

    public function confirm(Request $request)
    {
        abort_if(!in_array($request->status, ['accepted', 'cancel', 'cancelled']), 403);

        $request->validate(['ids' => 'required']);
        $ids = explode(',', $request->ids);
        $status = $request->status;
        if ($request->status == 'cancel' && auth()->user()->isAdmin()) {
            $status = 'cancelled';
        }
        foreach ($ids as $id) {
            if ($id) {
                $application = Application::findOrFail($id);
                if ($application->status == 'cancelled') {
                    return back()->with(['error' => 'Уже отменено']);
                }
                $application->update([
                    'status' => $status
                ]);
                if ($request->status == 'cancel') {
                    $agent = $application->agent;
                    $agent->balance -= $application->plan->price_sell;
                    $agent->save();
                }
            }
        }
        return back()->with(['success' => 'Процесс успешно']);
    }

    public function storeAddtionalPlan(Application $application)
    {
        request()->validate([
            'region_group_id' => 'required',
            'plan_id' => 'required',
        ]);

        $newApplication = $application->replicate();
        $newApplication->region_group_id = request()->region_group_id;
        $newApplication->plan_id = request()->plan_id;
        $newApplication->status = "new";
        $newApplication->save();
        return redirect()->route('admin.application.create', 'new')->with(['success' => 'Процесс успешно']);
    }

    public function addtionalPlan(Application $application)
    {

        $region_groups = RegionGroup::all();
        return view('admin.application.additional', compact('application', 'region_groups'));
    }
}
