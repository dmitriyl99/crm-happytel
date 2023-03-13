<?php

namespace App\Exports;
use App\Models\Newp;
use App\Models\PaymentAction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NewpExport implements  FromView
{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('admin.newp.excel',['entities' => $this->data]);
    }
}
