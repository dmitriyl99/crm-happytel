@extends('layouts.admin')
@section('title','Отчеты')

@section('content')

@php
$columns = [
'application->plan->type' => 'Тип тарифа',
'agent->title' => 'Агент',
'type' => 'Тип',
'fee' => 'Сумма',
'message' => 'Комментарий',
'application->plan->region_group->name' => 'Регион группа',
'application->plan->name' => 'План',
'simcard->esim' => 'eSim',
'application->plan->provider->name' => "Поставщик",
'application->customer->name' => "Клиент",
'application->user->name' => "Ползователь",
'application->payment_type' => 'Тип платежа',
'application->plan->price_arrival' => 'Цена прибытия',
'application->plan->price_sell' => 'Цена продажи',
'simcard->ssid' => 'ICCID',
'application->date_start' => 'Дата активации',
'application->date_finish' => 'Дата окончания',
'created_at' => 'Дата создания',
];
$table = 'table_reports';
session()->put($table,array_keys($columns));


$columnsu = [
'application->plan->type' => 'Fare type',
'fee' => 'Amount',
'application->plan->region_group->name' => 'Region Group',
'application->plan->name' => 'Plan',
'simcard->esim' => 'eSim',
'application->customer->name' => "Client",
'simcard->ssid' => 'ICCID',
'application->date_start' => 'Activation date',
'application->date_finish' => 'Expiration date',
'created_at' => 'Created at',
];
$table = 'table_reports';
if(empty(session()->get($table))){
session()->put($table,array_keys($columns));
}
@endphp
@include('admin.report.modals')
<div class="row">
    <div class="col-md-12">
        @if(auth()->user()->isUser())
        @else
        <div class="card">
            <div class="card-body">
                <a href="{{route('admin.report','agent')}}" class="btn @if(request()->report_type == 'agent') btn-primary @else btn-outline-primary  @endif ">
                    Отчет Агента
                </a>
                @endif
                @if(auth()->user()->isSuperAdmin())
                <a href="{{route('admin.report','provider')}}" class="btn @if(request()->report_type == 'provider') btn-primary @else btn-outline-primary  @endif ">
                    Отчет Поставщика
                </a>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        @if(auth()->user()->isUser())
                        @else
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="">Тип действия</label>
                                <select name="type" class="form-control">
                                    <option value="">Выбрать</option>
                                    <option value="entry" {{request()->type == 'entry' ? 'selected' : '' }}>Приход</option>
                                    <option value="exit" {{request()->type == 'exit' ? 'selected' : '' }}>Расход</option>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="">Тип платежа</label>
                                <select class="form-control" name="payment_type">
                                    <option value="">Выбрать</option>
                                    <option value="cashuzs" @if(request()->payment_type == 'cashuzs') selected @endif>Наличка uzs</option>
                                    <option value="cashusd" @if(request()->payment_type == 'cashusd') selected @endif>Наличка usd</option>
                                    <option value="uzcard" @if(request()->payment_type == 'uzcard') selected @endif>Uzcard</option>
                                    <option value="humo" @if(request()->payment_type == 'humo') selected @endif>Humo</option>
                                    <option value="visa" @if(request()->payment_type == 'visa') selected @endif>Visa</option>
                                    <option value="master_card" @if(request()->payment_type == 'master_card') selected @endif>Master Card</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        @if(auth()->user()->isAdmin())
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="">Агент</label>
                                <select class="form-control" name="agent_id">
                                    <option value="">Выбрать</option>
                                    @forelse($agents as $item)
                                    <option value="{{$item->id ?? ''}}" @if(request()->agent_id == $item->id) selected @endif>{{$item->title ?? ''}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="">Поставшик</label>
                                <select class="form-control" name="provider_id">
                                    <option value="">Выбрать</option>
                                    @forelse($providers as $item)
                                    <option value="{{$item->id ?? ''}}" @if(request()->provider_id == $item->id) selected @endif>{{$item->name ?? ''}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        @endif

                        {{-- <div class="col-md-3">
                            <div class="mb-2">
                                <label for="">Дата активации</label>
                                <input class="form-control" type="date" name="date_start" value="{{request()->date_start ? date('Y-m-d',strtotime(request()->date_start)) : ''}}">
                    </div>
            </div>

            <div class="col-md-3">
                <div class="mb-2">
                    <label for="">Дата окончания</label>
                    <input class="form-control" type="date" name="date_finish" value="{{request()->date_finish ? date('Y-m-d',strtotime(request()->date_finish)) : ''}}">
                </div>
            </div> --}}

            <div class="col-md-3">
                <div class="mb-2">
                    <label for="">Дата создания (от)</label>
                    <input class="form-control" type="date" name="from" value="{{request()->from ? date('Y-m-d',strtotime(request()->from)) : ''}}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="mb-2">
                    <label for="">Дата создания (до)</label>
                    <input class="form-control" type="date" name="to" value="{{request()->to ? date('Y-m-d',strtotime(request()->to)) : ''}}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="mb-2">
                    <label for="">ICCID</label>
                    <input class="form-control" type="text" name="ssid" value="{{request()->ssid ?? ''}}">
                </div>
            </div>
        </div>
        @if(auth()->user()->isUser())
        <button class="btn btn-primary" type="submit">
            Filter
        </button>
        {{-- {{dd(request()->query())}} --}}
        <a class="btn btn-success" href="?excel=1&{{http_build_query(request()->query())}}">Export to Excel</a>
        <a href="{{route('admin.report',request()->report_type)}}">Clear</a>
        @else
        <button class="btn btn-primary" type="submit">
            Фильтр
        </button>
        {{-- {{dd(request()->query())}} --}}
        <a class="btn btn-success" href="?excel=1&{{http_build_query(request()->query())}}">Экспорт в Excel</a>
        <a href="{{route('admin.report',request()->report_type)}}">Очистить фильтр</a>
        @endif
        </form>

    </div>
</div>
@if(auth()->user()->isUSer())
@else
<div class="card">
    <div class="card-body">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>Сим карты</th>
                    <th>Всего заработано</th>
                    <th>Всего отменено</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$simcardCount ?? 0}}</td>
                    <td>{{number_format($income ?? 0)}}</td>
                    <td>{{number_format($expenses ?? 0)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif
</div>
<div class="col-md-12">
    <div class="card">
        @if(auth()->user()->isUser())
        <div class="card-header">
            <div>
                <h4 class="card-title">Reports</h4>
                <p class="text-muted mb-0">
                    Here you can see all payment activities
                </p>
            </div>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                Payment actions
                <table class="table table-stripped">
                    @else
                    <div class="card-header">
                        <div>
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#columnFormModal"><i class="fa fa-cogs"></i></button>
                            <h4 class="card-title">Отчеты</h4>
                            <p class="text-muted mb-0">
                                Здесь вы можете увидеть все платежные действия
                            </p>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            Платежные действия
                            <table class="table table-stripped">
                                @endif
                                <thead>
                                    <tr>
                                        @if(auth()->user()->isUser())
                                        <th>#</th>
                                        @foreach($columnsu as $key => $column)
                                        @if(
                                        !in_array($key, session($table) ?? []) ||
                                        (
                                        !auth()->user()->isAdmin() &&
                                        in_array($key,['payment_type','price_arrival','price_sell'])
                                        )
                                        )
                                        @continue
                                        @endif
                                        <th>{{$column}}</th>
                                        @endforeach
                                        @elseif(auth()->user()->isAgent())
                                        <th>№</th>
                                        <th>Тип тарифа</th>
                                        <th>Агент</th>
                                        <th>Тип</th>
                                        <th>Сумма</th>
                                        <th>Комментарий</th>
                                        <th>Регион группа</th>
                                        <th>План</th>
                                        <th>eSim</th>
                                        <th>Клиент</th>
                                        <th>Ползователь</th>
                                        <th>Тип платежа</th>
                                        <th>Цена продажи</th>
                                        <th>ICCID</th>
                                        <th>Дата активации</th>
                                        <th>Дата окончания</th>
                                        <th>Дата создания</th>
                                        <th></th>
                                        @else
                                        <th>#</th>
                                        @foreach($columns as $key => $column)
                                        @if(
                                        !in_array($key, session($table) ?? []) ||
                                        (
                                        !auth()->user()->isAdmin() &&
                                        in_array($key,['payment_type','price_arrival','price_sell'])
                                        )
                                        )
                                        @continue
                                        @endif
                                        <th>{{$column}}</th>
                                        @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- For user  -->
                                    @if(auth()->user()->isUser())
                                    @foreach($entities as $item)
                                    <tr>
                                        <td>{{($entities->currentpage()-1) * $entities->perpage() + $loop->index + 1 }}</td>
                                        <td>
                                            @if(auth()->user()->isUser())
                                            @if(isset($item->application->plan) && $item->application->plan->type == 'normal')
                                            <span class='btn btn-success btn-sm'>Ordinary</span>
                                            @else
                                            <span class='btn btn-warning btn-sm'>Additional</span>
                                            @endif
                                            @else
                                            @if(isset($data->plan) && $data->plan->type == 'normal')
                                            <span class='btn btn-success btn-sm'>Обычные</span>
                                            @else
                                            <span class='btn btn-warning btn-sm'>Дополнительныеs</span>
                                            @endif
                                            @endif
                                        </td>
                                        <td>{{$item->application->plan->price_user ?? 0}} $</td>
                                        <td>{{$item->application->plan ? $item->application->region_group ? $item->application->region_group->name : '' : ''}}</td>
                                        <td>{{$item->application->plan->name ?? ''}}</td>
                                        <td>
                                            @if($item->application->simcard->esim)
                                                <img src="{{ asset('assets/images/check-circle.svg')}}" alt="esim" class="logo-sm logo-light">
                                            @endif
                                        </td>
                                        <td>{{$item->application->customer->full_name ?? ''}}<br>
                                            {{$item->application->customer->phone ?? ''}}
                                        </td>
                                        <td>
                                            <a href="{{route('admin.application.show',$item->application->id ?? 0)}}" target="_blank">
                                                {{$item->application->simcard->ssid ?? ''}}
                                            </a>
                                        </td>
                                        <td>{{date('d-m-Y',strtotime($item->application->date_start ?? 'now'))}}</td>
                                        <td>{{date('d-m-Y',strtotime($item->application->date_finish))}}</td>
                                        <td>{{date('d-m-Y H:i:s',strtotime($item->created_at ?? 'now'))}}</td>
                                    </tr>
                                    @endforeach
                                    @elseif(auth()->user()->isAgent())
                                    @foreach($entities as $item)
                                    <tr>
                                        <td>{{($entities->currentpage()-1) * $entities->perpage() + $loop->index + 1 }}</td>
                                        <td>
                                            @if(isset($item->application->plan) && $item->application->plan->type == 'normal')
                                            <span class='btn btn-success btn-sm'>Обычные</span>
                                            @else
                                            <span class='btn btn-warning btn-sm'>Дополнительные</span>
                                            @endif
                                        </td>
                                        <td> {{$item->agent->title ?? ''}}</td>
                                        <td>
                                            @if($item->type == 'entry')
                                            Приход
                                            @else
                                            Расход
                                            @endif</td>
                                        <td>
                                            @if($item->type == 'entry')
                                            <span class="text-success">+ {{number_format($item->fee ?? '')}}</span>
                                            @else
                                            <span class="text-danger">-{{number_format($item->fee ?? '')}}</span>
                                            @endif
                                        </td>
                                        <td>{{$item->message ?? ''}}</td>
                                        <td>{{$item->application->plan ? $item->application->region_group ? $item->application->region_group->name : '' : ''}}</td>
                                        <td>{{$item->application->plan->name ?? ''}}</td>
                                        <td>
                                            @if($item->application->simcard->esim)
                                                <img src="{{ asset('assets/images/check-circle.svg')}}" alt="esim" class="logo-sm logo-light">
                                            @endif
                                        </td>
                                        <td>{{$item->application->customer->full_name ?? ''}}<br>
                                            {{$item->application->customer->phone ?? ''}}
                                        </td>
                                        <td>{{$item->application->user->name ?? $item->user->name ?? ''}}</td>
                                        <td>{{customPaymentType($item->application->payment_type ?? '')}}</td>
                                        <td>{{number_format($item->application->plan->price_sell ?? 0)}}</td>
                                        <td>
                                            <a href="{{route('admin.application.show',$item->application->id ?? 0)}}" target="_blank">
                                                {{$item->application->simcard->ssid ?? ''}}
                                            </a>
                                        </td>
                                        <td>{{date('d-m-Y',strtotime($item->application->date_start ?? 'now'))}}</td>
                                        <td>{{date('d-m-Y',strtotime($item->application->date_finish ?? 'now'))}}</td>
                                        <td>{{date('d-m-Y H:i:s',strtotime($item->created_at ?? 'now'))}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    @foreach($entities as $item)
                                    <tr>
                                        <td>{{($entities->currentpage()-1) * $entities->perpage() + $loop->index + 1 }}</td>

                                        @foreach($columns as $key => $column)
                                        @if(
                                        !in_array($key, session()->get($table) ?? []) ||
                                        (
                                        !auth()->user()->isAdmin() &&
                                        in_array($key,['payment_type','price_arrival','price_sell'])
                                        )
                                        )
                                        @continue
                                        @endif
                                        <td>
                                            @if($key == 'fee')
                                            @if($item->type == 'entry')
                                            <span class="text-success">+ {{number_format($item->$key ?? '')}}</span>
                                            @else
                                            <span class="text-danger">-{{number_format($item->$key ?? '')}}</span>
                                            @endif
                                            @elseif($key == 'type')
                                            @if($item->type == 'entry')
                                            Приход
                                            @else
                                            Расход
                                            @endif
                                            @elseif($key == 'agent->title')
                                            {{$item->agent->title ?? ''}}
                                            @elseif($key == 'application->payment_type')

                                            {{customPaymentType($item->application->payment_type ?? '')}}
                                            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                            @elseif($key == 'application->plan->price_arrival')
                                            {{number_format($item->application->plan->price_arrival ?? 0)}}
                                            @endif
                                            @elseif($key == 'application->plan->price_sell')
                                            {{number_format($item->application->plan->price_sell ?? 0)}}

                                            @elseif($key == 'simcard->ssid')
                                            <a href="{{route('admin.application.show',$item->application->id ?? 0)}}" target="_blank">
                                                {{$item->application->simcard->ssid ?? ''}}
                                            </a>
                                            @elseif($key == 'application->date_start' && isset($item->application))
                                            {{date('d-m-Y',strtotime($item->application->date_start ?? 'now'))}}

                                            @elseif($key == 'application->date_finish' && isset($item->application))
                                            {{date('d-m-Y',strtotime($item->application->date_finish))}}

                                            @elseif($key == 'created_at')
                                            {{date('d-m-Y H:i:s',strtotime($item->created_at ?? 'now'))}}

                                            @elseif($key == 'application->plan->region_group->name' && isset($item->application))
                                                {{$item->application->plan ? $item->application->region_group ? $item->application->region_group->name : '' : ''}}

                                            @elseif($key == 'application->plan->name' && isset($item->application))
                                            {{$item->application->plan->name ?? ''}}

                                            @elseif($key == 'simcard->esim' && isset($item->application))
                                                @if($item->application->simcard->esim)
                                                    <img src="{{ asset('assets/images/check-circle.svg')}}" alt="esim" class="logo-sm logo-light">
                                                @endif

                                            @elseif($key == 'message')
                                            {{$item->message ?? ''}}
                                            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                            @elseif($key == 'application->plan->provider->name' && isset($item->application))
                                            {{$item->application->plan->provider->name ?? ''}}
                                            @endif
                                            @elseif($key == 'application->customer->name')
                                            {{$item->application->customer->full_name ?? ''}}<br>
                                            {{$item->application->customer->phone ?? ''}}

                                            @elseif($key == 'application->user->name')
                                            {{$item->application->user->name ?? $item->user->name ?? ''}}

                                            @elseif($key == 'application->plan->type')
                                            @if(isset($item->application->plan) && $item->application->plan->type == 'normal')
                                            <span class='btn btn-success btn-sm'>Обычные</span>
                                            @else
                                            <span class='btn btn-warning btn-sm'>Дополнительные</span>
                                            @endif
                                            @else
                                            {{ $item->$key ?? ''}}
                                            @endif
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div>
                        <!--end /tableresponsive-->
                        {!! $entities->appends(Request::except('page'))->render() !!}
                    </div>
                    <!--end card-body-->
            </div>
        </div>
    </div>

    <!--end row-->
    <!-- end page title end breadcrumb -->
    @endsection

    @section('js')

    <script>
        $(document).ready(function() {
            $(document).on("click", "#labelCheckAll", function() {
                $('.customColumn:checkbox').each(function() {
                    if ($('input#checkAllCheckbox').is(':checked')) {
                        $(this).prop('checked', false);
                    } else {
                        $(this).prop('checked', true);
                    }
                });
            });
        });
    </script>

    @endsection
