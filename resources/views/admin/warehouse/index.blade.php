@extends('layouts.admin')
@section('title','Актуальный склад')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <form method="GET" action="{{route('admin.warehouse.index')}}">
            <div class="input-group mb-3">
                <input type="text" value="{{ request()->key ?? ''}}" name="key" class="form-control" placeholder="Название | Описание  | Штрих Код Товара" aria-label="Название | Описание  | Регион" aria-describedby="button-addon2">
                <button class="btn btn-secondary" type="submit" id="button-addon2">Поиск</button>
            </div>
        </form>

    </div>

    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <div>
                    <h4 class="card-title">История поступлений на склад</h4>
                    <p class="text-muted mb-0 fw-semibold">Количество: {{$productIncomes->total()}}</p>
                    <p class="text-muted mb-0">Здесь вы можете увидеть историю поступлений товаров на склад
                        <a href="{{route('admin.warehouse.index')}}"
                           class="btn btn-warning btn-sm" data-bs-toggle="modal"
                           data-bs-target="#importWarehouseProducts">Импортировать Приход товаров</a>
                        <a href="{{route('admin.warehouse.create')}}" class="btn btn-success float-end">Добавить новое поступление товаров</a>
                    </p>
                </div>
            </div>
            <div class="card-body min-height-350">
                <div class="table-responsive">
                    <table class="table mb-0 table-centered">
                        <thead>
                            <tr>
                                <th>Номер</th>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Цена Прихода</th>
                                <th>Цена Продажи usd</th>
                                <th>Цена Продажи uzs</th>
                                <th>Дата создание</th>
                                <th>Количество</th>
                                <th>Штрих Код</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productIncomes as $data)
                            <tr class="cursor-pointer" ondblclick="window.location.href='{{route('admin.warehouse.edit',$data->id)}}'">
                                <td>{{($productIncomes->currentpage()-1) * $productIncomes->perpage() + $loop->index + 1 }}</td>

                                <td>
                                    {{$data->product->name}}
                                </td>
                                <td>
                                    {{$data->product->desc}}
                                </td>
                                <td>
                                    {{$data->product->price_1}}
                                </td>
                                <td>
                                    {{$data->product->price_2}}
                                </td>
                                <td>
                                    {{$data->product->price_3}}
                                </td>
                                <td>
                                    {{$data->created_at}}
                                </td>
                                <td>
                                    {{$data->count}}
                                </td>
                                <td>
                                    {{$data->barcode}}
                                </td>
                                <td class="text-end">
                                    <form id="form{{$data->id}}" action="{{route('admin.warehouse.destroy',$data->id)}}" method="post" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v font-20 text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                            <a class="dropdown-item" href="{{route('admin.warehouse.edit',$data->id)}}">Изменить</a>
                                            <a class="dropdown-item" href="javascript:;" onclick="confirm('Вы уверены, что удалите его?') ? document.getElementById('form{{$data->id}}').submit() : false">Удалить</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <!--end /table-->
                </div>
                <!--end /tableresponsive-->
                <div class="mb-3"></div>
                {{$productIncomes->links()}}
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
<div class="modal fade" id="importWarehouseProducts" tabindex="-1" role="dialog" aria-labelledby="importLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" action="{{route('admin.warehouse.import')}}" id="import"
              enctype="multipart/form-data" method="POST">
            @csrf
            <div class="modal-header">
                <h6 class="modal-title m-0" id="importLabel">Импортировать Приход товаров</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom-file">
                            <label class="custom-file-label" for="excel">Выберите файл</label>
                            <input type="file" name="file" class="custom-file-input form-control"
                                   id="excel">
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">
                    Закрыть
                </button>
                <button type="submit" name="submit" class="btn btn-primary btn-sm">Загрузить
                </button>
            </div>
            <!--end modal-footer-->
        </form>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
@endsection
