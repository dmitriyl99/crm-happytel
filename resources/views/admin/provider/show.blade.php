@extends('layouts.admin')
@section('title','Клиенты')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="">ФИО</label>
                    <div class="text-secondary">{{$customer->full_name ?? ''}}</div>
                </div>
                <div class="mb-3">
                    <label for="">Телефон</label>
                    <div class="text-secondary">{{$customer->phone ?? ''}}</div>
                </div>

                <div class="mb-3">
                    <label for="">Статус</label>
                    <div class="text-secondary">{{$customer->status ?? ''}}</div>
                </div>

                <div class="mb-3">
                    <label for="">Пасспорт</label>
                    <div class="text-secondary">
                        <a href="{{$customer->passport}}">
                            <img src="{{$customer->passport ?? ''}}" alt="passport">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div>
                    <h4 class="card-title">Заявки</h4>
                    <p class="text-muted mb-0 fw-semibold">Количество: {{$customer->applications->count()}}</p>

                </div>
            </div>
            <div class="card-body min-height-350">

                <div class="table-responsive">
                    <table class="table mb-0 table-centered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th></th>
                                <th>Статус</th>
                                <th>Регион</th>
                                <th>Тариф</th>
                                <th>Сим карт</th>
                                <th>Дата активации </th>
                                <th>Дата окончания </th>
                                <th>Kлиент</th>
                                <th>Оплата</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->applications as $data)
                           
                            <tr>
                                <td><input type="checkbox" class="table-checkbox" value="{{$data->id}}"></td>
                                <td>{{$loop->iteration}}</td>
                                <td>{{customStatusColor($data->status)}}</td>
                                <td>{{$data->region->name ?? ''}}</td>
                                <td>{{$data->plan->name ?? ''}}</td>
                                <td>
                               
                                    @foreach($data->simcards as $key => $item)
                                    @php
                                    $simcards[] = $item
                                    @endphp
                                    <span class="badge bg-primary">{{$item->ssid ?? ''}}</span><br>
                                    @endforeach
                                    
                                </td>
                                <td>{{customDate($data->date_start)}}</td>
                                <td>{{customDate($data->date_finish)}}</td>
                                <td>
                                    <a href="{{route('admin.customer.show',$data->customer->id)}}" target="_blank">
                                    {{$data->customer->full_name ?? ''}}
                                    {{$data->customer->phone ?? ''}}
                                    </a>    
                                </td>
                                <td>
                                    {{customPaymentType($data->payment_type)}}
                                </td>
                                <td class="text-end">
                                    <form id="form{{$data->id}}" action="{{route('admin.application.destroy',$data->id)}}" method="post" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v font-20 text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                            <a class="dropdown-item" href="{{route('admin.application.edit',$data->id)}}">Изменить</a>
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
             
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div>
                    <h4 class="card-title">Симкарты</h4>
                    <p class="text-muted mb-0 fw-semibold">Количество: {{count($simcards)}}</p>

                </div>
            </div>
            <div class="card-body min-height-350">

                <div class="table-responsive">
                    <table class="table mb-0 table-centered min-heght-200 table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>SSID</th>
                                <th>Тариф</th>
                                <th>Регион</th>
                                <th>Цена</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $simcards as $data)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <th><input type="checkbox" class="table-checkbox" value="{{$data->id}}"></th>
                                <td>{{$data->ssid ?? ''}}</td>
                                <td>{{$data->plan->name ?? ""}}</td>
                                <td>{{$data->region->name ?? ''}}</td>
                                <td>{{$data->price ?? ''}}</td>
                                <td class="text-end">
                                    <form id="form{{$data->id}}" action="{{route('admin.simcard.destroy',$data->id)}}" method="post" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v font-20 text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                            <a class="dropdown-item" href="{{route('admin.simcard.edit',$data->id)}}">Изменить</a>
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
             
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
