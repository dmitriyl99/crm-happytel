@extends('layouts.admin')
@section('title','Проданные Гаджеты')

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
                                <label for="">Тип платежа</label>
                                <select class="form-control" name="payment_type">
                                    <option value="">Выбрать</option>
                                    <option value="cash" @if(request()->payment_type == 'cash') selected @endif>Наличка</option>
                                    <option value="uzcard" @if(request()->payment_type == 'uzcard') selected @endif>Uzcard</option>
                                    <option value="humo" @if(request()->payment_type == 'humo') selected @endif>Humo</option>
                                    <option value="visa" @if(request()->payment_type == 'visa') selected @endif>Visa</option>
                                    <option value="master_card" @if(request()->payment_type == 'master_card') selected @endif>Master Card</option>
                                </select>
                            </div>
                        </div>
                        @if(auth()->user()->isAdmin())
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="">Название товара</label>
                                <select class="form-control" name="product_id">
                                    <option value="">Выбрать</option>
                                    @forelse($lists as $item)
                                    <option value="{{$item->id ?? ''}}" @if(request()->product_id == $item->id) selected @endif>{{$item->name ?? ''}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="">Дата создания (от)</label>
                                <input class="form-control" type="date" name="from" value="{{request()->from ? date('Y-m-d',strtotime(request()->from)) : ''}}">
                            </div>
                        </div>

                    </div>
                    <button class="btn btn-primary" type="submit">
                        Фильтр
                    </button>
                    <a href="{{route('admin.newp.index',request()->report_type)}}">Очистить фильтр</a>
                    <a class="btn btn-success" href="?excel=1&{{http_build_query(request()->query())}}">Экспорт в Excel</a>
                </form>

            </div>
        </div>
        <div class="card-header">
            <div>
                <h4 class="card-title">Гаджеты</h4>
                <p class="text-muted mb-0 fw-semibold">Количество: {{$newp->total()}}</p>
                <p class="text-muted mb-0">Здесь вы можете увидеть все проданные Гаджеты <a href="{{route('admin.newp.create')}}" class="btn btn-success float-end">Создать</a>
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
                            <th>Тип платежа</th>
                            <th>Дата создание</th>
                            <th>Количество</th>
                            <th>Цена Продажи uzs</th>
                            <th>Пользователь</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entities as $item)
                        <tr>
                            <td>{{($entities ->currentpage()-1) * $entities ->perpage() + $loop->index + 1 }}</td>


                            <td>
                                {{$item->listproduct->name ?? ''}}
                            </td>
                            <td>
                                {{($item->setting->value ?? '')}}
                            </td>
                            <td>
                                {{($item->created_at ?? '')}}
                            </td>
                            <td>
                                {{($item->count ?? '')}}
                            </td>
                            <td>{{ $item->listproduct->price_3 ?? ''}}</td>
                            <td>
                                {{($item->customer_id ?? '')}}
                            </td>
                            <td class="text-end">
                                <form id="form{{$item->id}}" action="{{route('admin.newp.destroy',$item->id)}}" method="post" class="d-none">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                <div class="dropdown d-inline-block">
                                    <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <i class="las la-ellipsis-v font-20 text-muted"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                        <a class="dropdown-item" href="javascript:;" onclick="confirm('Вы уверены, что удалите его?') ? document.getElementById('form{{$item->id}}').submit() : false">Удалить</a>
                                    </div>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                        </tr>
                    </tbody>
                </table>
                <!--end /table-->
            </div>
            <!--end /tableresponsive-->
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
