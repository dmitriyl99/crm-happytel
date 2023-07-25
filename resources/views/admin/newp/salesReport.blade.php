@extends('layouts.admin')
@section('title','Отчет по продажам гаджетов')

@section('content')

<!-- Page-Title -->
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="">Дата (от)</label>
                                <input class="form-control" type="date" name="from" value="{{request()->from ? date('Y-m-d',strtotime(request()->from)) : ''}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="">Дата (до)</label>
                                <input class="form-control" type="date" name="to" value="{{request()->to ? date('Y-m-d',strtotime(request()->to)) : ''}}">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">
                        Фильтр
                    </button>
                    <a href="{{route('admin.newp.sales.report')}}">Очистить фильтр</a>
                    <a class="btn btn-success" href="?excel=1&{{http_build_query(request()->query())}}">Экспорт в Excel</a>
                </form>

            </div>
        </div>
        <div class="card-header">
            <div>
                <h4 class="card-title">Проданные Гаджеты</h4>
                <p class="text-muted mb-0 fw-semibold">Количество: {{$products->total()}}</p>
            </div>
        </div>
        <div class="card-body min-height-350">
            <div class="table-responsive">
                <table class="table mb-0 table-centered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="border-top border-start border-bottom border-end">Номер</th>
                            <th rowspan="2" class="border-top border-end border-bottom">Название товара</th>
                            <th colspan="2" class="border-end border-start border-top">Продано</th>
                            <th colspan="2" class="border-end border-top">Остаток</th>
                        </tr>
                        <tr>
                            <th class="border-end border-top border-bottom">Количество</th>
                            <th class="border-end border-top border-bottom">Стоимость</th>
                            <th class="border-end border-top border-bottom">Количество</th>
                            <th class="border-top border-end border-bottom">Стоимость</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{($products->currentpage()-1) * $products ->perpage() + $loop->index + 1 }}</td>
                            <td>
                                {{$product->name ?? ''}}
                            </td>
                            <td>{{ $product->sales_count ?? ''}}</td>
                            <td>{{ $product->sales_amount ?? ''}}</td>
                            <td>
                                {{($product->warehouse_count ?? '')}}
                            </td>
                            <td>{{ $product->warehouse_amount ?? ''}}</td>
                            @endforeach
                        </tr>
                        </tr>
                    </tbody>
                </table>
                <!--end /table-->
            </div>
            <!--end /tableresponsive-->
            <!--end card-body-->
            <div class="mb-3"></div>
            {{$products->links()}}
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
