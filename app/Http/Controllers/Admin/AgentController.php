<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Http\Requests\AgentRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\PaymentAction;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = Agent::query()->paginate(100);
        return view('admin.agent.index',compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.agent.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentRequest $request)
    {
        Agent::create([
            'title' => $request->title,
            'address' => $request->address,
            'status' => $request->status,
            'phone' => $request->phone,
            'balance' => $request->balance,
        ]);

        return redirect()->route('admin.agent.index')->with(['success' => 'Создано успешно']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agent = Agent::where('id',$id)->with([
            'notifications','users','paymentActions'])
            ->withCount(['activeSimcards','inActiveSimcards'])
            ->first();
        return view('admin.agent.show',compact('agent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        return view('admin.agent.edit',compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AgentRequest $request, $id)
    {
        $agent = Agent::findOrFail($id);
        $agent->update([
            'title' => $request->title,
            'address' => $request->address,
            'status' => $request->status,
            'phone' => $request->phone,
            'balance' => $request->balance,
        ]);
        return redirect()->route('admin.agent.edit',$id)->with(['success' => 'Успешно обновлено']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $agent = Agent::findOrFail($id);
        // $agent->update(['status' => 'inactive']);

        // $user = User::findOrFail($agent->user_id);
        // $user->update(['status' => 'active']);
        // return redirect()->route('admin.agent.index')->with(['success' => 'Сделал неактивным!']);
    }

    public function pay(Request $request)
    {
        $request->validate([
            'agent_id' => 'required',
            'sum' => 'required|numeric',
            'payment_date' => 'required',
        ]);
        $agent = Agent::findOrFail($request->agent_id);
        $agent->update([
            'balance' => $agent->balance + $request->sum,
        ]);
        
        PaymentAction::create([
            'fee' => request()->sum,
            'agent_id' => request()->agent_id,
            'message' => config('a_status.balance_filled', 'Баланс заполнен'),
            'type' => 'entry',
            'action' => 'agent',
            'created_at' => request()->payment_date,
            'user_id' => auth()->user()->id
        ]);

        return back()->with(['success' => 'Оплачено успешно']);
    }
}
