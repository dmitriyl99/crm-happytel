@extends('layouts.admin')
@section('title','Подробность Агент')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">Подробность агента</div>
            <div class="card-body">
              
                <h3>Остаток средств: {{$agent->balance ?? ''}}</h3>
                <div class="row">
                    <div class="col-md-12">
                       <p> <b>Полное название</b>: {{$agent->title ?? ''}}</p>
                       <p> <b>Телефон</b>: {{$agent->phone ?? ''}}</p>
                       <p> <b>Адрес</b>: {{$agent->address ?? ''}}</p>
                       <p> <b>Статус</b>: {{$agent->status ?? ''}}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    
                    <div class="col-md-6">
                        Список пользователей
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Имя</th>
                                    <th>логин</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agent->users as $item)
                                    <tr>
                                        <td>{{$loop->iteration ?? ''}}</td>
                                        <td>
                                            {{$item->name ?? ''}}
                                        </td>
                                        <td>{{$item->login ?? ''}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        SIM-карты
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Активный</th>
                                    <th>Неактивный</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>{{$agent->active_simcards_count ?? ""}}</td>
                                    <td>{{$agent->in_active_simcards_count ?? ""}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        Платежные действия
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Сумма</th>
                                    <th>Комментарий</th>
                                    <th>ID сим-карты</th>
                                    <th>Дата создания</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agent->paymentActions as $item)
                                    <tr>
                                        <td>{{$loop->iteration ?? ''}}</td>
                                        <td>
                                            @if($item->type == 'entry')
                                            <span class="text-success">+ {{$item->fee ?? ''}}</span>
                                            @else 
                                            <span class="text-danger">- {{$item->fee ?? ''}}</span>
                                            @endif
                                        </td>
                                        <td>{{$item->message ?? ''}}</td>
                                        <td>{{$item->simcard_id ?? ''}}</td>
                                        <td>{{$item->created_at ?? ''}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
