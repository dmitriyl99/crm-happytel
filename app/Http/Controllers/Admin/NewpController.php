<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewpRequest;
use App\Models\ProductIncome;
use App\Models\ProductSales;
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
            Newp::create([
                'product_id' => $item['product_id'],
                'payment_type' => $request->payment_type,
                'customer_id' => auth()->user()->name, // тот кто продал
                'count' => $item['count']
            ]);
            /** @var Listproduct $product */
            $product = Listproduct::findOrFail($item['product_id']);
            /** @var ProductIncome $productIncome */
            $productIncome = ProductIncome::query()
                ->where('barcode', $product->barcode)
                ->first();
            if ($product->count > 0 and $productIncome->count > 0) {
                $productSale = new ProductSales();
                $productSale->product_id = $product->id;
                $productSale->product_income_id = $productIncome->id;
                $productSale->count = intval($item['count']);
                $productSale->barcode = $product->barcode;
                $productSale->selling_price_uzs = $product->price_3; # TODO remove from migration add payment_type
                $productSale->sold_by_id = auth()->user()->id;
                $productSale->created_at = now();
                $productSale->updated_at = now();
                $productSale->save();

                $fields = [
                    'count' => $product->count - $item['count'],
                ];
                $product->update($fields);
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
