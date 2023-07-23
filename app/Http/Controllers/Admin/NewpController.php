<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewpRequest;
use App\Models\Warehouse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Newp;
use App\Models\Listproduct;
use App\Exports\NewpExport;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;
use App\Helpers\FileUpload;


class NewpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    // public function index(){
    //     $lists = Listproduct::all();
    //     $newp = newp::query()->paginate(10);
    //     return view('admin.newp.index', compact('newp','lists'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $lists = Listproduct::all();
        return view('admin.newp.create', compact('lists'));
    }

    public function edit($id)
    {

        $lists = Listproduct::all();
        $newp = Newp::findOrFail($id);
        return view('admin.newp.edit', compact('newp', 'lists'));
    }


    public function destroy($id)
    {
        $newp = Newp::findOrFail($id);
        $newp->delete();
        return redirect()->route('admin.newp.index')->with(['success' => 'Удалено!']);
    }




    // public function store(NewpRequest $request)
    // {
    //     $newp = Newp::create([
    //         'product_id' => $request->product_id,
    //         'payment_type' => $request->payment_type,
    //         'count' => $request->count
    //     ]);
    // $list= Listproduct::where('id',$request->product_id)->first();
    // $user = Listproduct::findOrFail($request->product_id);
    // $fields = [
    //     'count' => $user->count - $request->count,
    // ];
    // $list->update($fields);
    //     return redirect()->route('admin.newp.index')->with(['success' => 'Successfully created!']);
    // }








    public function store(NewpRequest $request)
    {
        foreach ((session('newp') ?? []) as $key => $item) {
            /** @var Listproduct|null $product */
            $product = Listproduct::query()->find($item['product_id']);

            if ($product === null) {
                continue;
            }

            /** @var Warehouse|null $first_income_in_warehouse */
            $first_income_in_warehouse = Warehouse::query()
                ->where('product_id', $product->id)
                ->where('count', '>', 0)
                ->orderBy('created_at')
                ->first();

            $new_sale = new Newp();
            $new_sale->product_id = $item['product_id'];
            $new_sale->product_income_id = $first_income_in_warehouse ? $first_income_in_warehouse->product_income_id : null;
            $new_sale->payment_type = $request->payment_type;
            $new_sale->customer_id = auth()->user()->name; // тот кто продал
            $new_sale->count = $item['count'];
            $new_sale->save();


            if ($product->count > 0) {
                $fields = [
                    'count' => $product->count - $item['count'],
                ];
                $product->update($fields);
            }
            if ($first_income_in_warehouse != null and $first_income_in_warehouse->count > 0) {
                $first_income_in_warehouse->update([
                    'count' => $first_income_in_warehouse->count - intval($item['count']),
                    'updated_at' => now()
                ]);
            }
        }

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
        return redirect()->route('admin.newp.index')->with(['success' => 'Создано успешно']);
    }






    public function index(Request $request)
    {
        $entityQuery = Newp::query()->where(function ($query) use ($request) {

            if (request()->product_id) {
                $query->where('product_id', request()->product_id);
            }
            if (request()->from) {
                $query->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime(request()->from)));
            }
            if (request()->to) {
                $query->where('created_at', '<=', date('Y-m-d 23:59:00', strtotime(request()->to)));
            }
            if (request()->payment_type) {
                $query->where('payment_type', request()->payment_type);
            }
        })->orderBy('created_at', 'DESC')->with([
            'listproduct', 'customer'
        ]);
        if ($request->excel) {
            $newQuery = clone $entityQuery;
            $excelData = $newQuery->get();
            $nameFile = date('d-m-Y', strtotime('now'));
            return Excel::download(new NewpExport($excelData), $nameFile . '-products.xlsx');
        }

        $newQuery = clone $entityQuery;


        $lists = Listproduct::all();
        $newp = newp::query()->paginate(10);
        $entities = $entityQuery->paginate(20);
        //         dd($entities);
        return view('admin.newp.index', compact('lists', 'newp', 'entities'));
    }
}
