<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agent;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Models\PaymentAction;
use App\Exports\PaymentActionExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $report_type)
    {
        abort_if(!in_array($report_type, ['agent', 'provider']), 404);

        $entityQuery = PaymentAction::where('action', $report_type)->where(function ($query) {
            if (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin()) {
                if (!auth()->user()->isSuperAdmin() && !request()->agent_id) {
                    $query->where('agent_id', auth()->user()->agent_id);
                }

                if (request()->agent_id) {
                    $query->where('agent_id', request()->agent_id);
                }
                if (request()->type) {
                    $query->where('type', request()->type);
                }
                if (request()->from) {
                    $query->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime(request()->from)));
                }

                if (request()->to) {
                    $query->where('created_at', '<=', date('Y-m-d 23:59:00', strtotime(request()->to)));
                }
            } else if (!auth()->user()->isUser()) {
                $query->where('agent_id', auth()->user()->agent_id);
            }
            if (auth()->user()->isUser()) {
                if (!auth()->user()->isSuperAdmin() && !request()->agent_id) {
                    $query->where('agent_id', 1);
                }
                if (date('Y-m-d 00:00:00', strtotime('2022-11-8 00:00:00')) > date('Y-m-d 00:00:00', strtotime(request()->from))) {
                    request()->from = "2022-11-8 00:00:00";
                }
                if (request()->from) {
                    $query->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime(request()->from)));
                }

                if (request()->to) {
                    $query->where('created_at', '<=', date('Y-m-d 23:59:00', strtotime(request()->to)));
                }
                $query->whereHas('application', function ($query) {
                    $query->whereHas('plan', function ($query) {
                        $query->where('provider_id', 1);
                    });
                });
            }
            if (request()->date_start || request()->date_finish || request()->payment_type || request()->creatd_at) {
                $query->whereHas('application', function ($query) {
                    if (request()->date_start) {
                        $query->where('date_start', '>=', date('Y-m-d 00:00:00', strtotime(request()->date_start)));
                    }

                    if (request()->date_finish) {
                        $query->where('date_finish', '<=', date('Y-m-d 23:59:00', strtotime(request()->date_finish)));
                    }

                    if (request()->payment_type) {
                        $query->where('payment_type', request()->payment_type);
                    }
                    if (request()->provider_id) {
                        $query->whereHas('plan', function ($query) {
                            $query->where('provider_id', request()->provider_id);
                        });
                    }
                    if (request()->creatd_at) {
                        $query->whereHas('simcard', function ($query) {
                            $query->where('ssid', 'like', '%' . request()->ssid . '%');
                        });
                    }
                });
            }
        })->orderBy('created_at', 'DESC')->with([
            'agent',
            'application',
            'application.simcard',
            'application.customer',
            'application.plan',
            'application.plan.provider',
        ]);

        if ($request->excel) {
            $newQuery = clone $entityQuery;
            $excelData = $newQuery->get();
            $nameFile = date('d-m-Y', strtotime('now'));
            return Excel::download(new PaymentActionExport($excelData), $nameFile . '-payments.xlsx');
        }

        $newQuery = clone $entityQuery;


        $simcardCount = $newQuery->count();

        $newQuery = clone $entityQuery;
        $income = $newQuery->where('type', 'exit')->get()->sum('fee');

        $newQuery = clone $entityQuery;
        $expenses = $newQuery->where('type', 'entry')->get()->sum('fee');

        $agents = Agent::all();
        $providers = Provider::all();
        $entities = $entityQuery->paginate(20);
        //dd($entities);

        return view('admin.report.index', compact('entities', 'agents', 'simcardCount', 'income', 'expenses', 'providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
