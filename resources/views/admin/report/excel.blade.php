@php
    $columns = [
    'agent->title' => 'Агент',
    'type' => 'Тип',
    'fee' => 'Сумма',
    'message' => 'Комментарий',
    'application->plan->region_group->name' => 'Регион группа',
    'application->plan->name' => 'План',
    'application->plan->provider->name' => "Поставшик",
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


    $protectedColumns = [
    'application->payment_type',
    'application->plan->price_arrival',
    'application->plan->provider->name',
    'application->plan->price_sell'
    ];

    $columnsu = [
    'application->plan->type' => 'Fare type',
    'fee' => 'Amount',
    'application->plan->name' => 'Plan',
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

<table>
    <thead>
    <tr>
        <th>#</th>
        @if(auth()->user()->isUser())
            @foreach($columnsu as $key => $column)
                @if(!in_array($key, session($table) ?? []) ||
                (!auth()->user()->isAdmin() &&
                in_array($key,['payment_type','price_arrival','price_sell']) )
                )
                    @continue
                @endif
                <th>{{$column}}</th>
            @endforeach
        @else
            @foreach($columns as $key => $column)
                @if( !in_array($key, session()->get($table) ?? []))
                    @continue
                @endif
                @if(!auth()->user()->isAdmin() && in_array($key,$protectedColumns))
                    @continue
                @endif
                <th>{{$column}}</th>
            @endforeach
        @endif
    </tr>
    </thead>
    <tbody>
    @if(auth()->user()->isUser())
        @foreach($entities as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
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
                <td>{{$item->application->plan->name ?? ''}}</td>
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
    @else
        @foreach($entities as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                @foreach($columns as $key => $column)
                    @if( !in_array($key, session()->get($table) ?? []))
                        @continue
                    @endif
                    @if(!auth()->user()->isAdmin() && in_array($key,$protectedColumns))
                        @continue
                    @endif
                    <td>

                        @if($key == 'fee')
                            @if($item->type == 'entry')
                                {{$item->$key ?? ''}}
                            @else
                                {{$item->$key ?? ''}}
                            @endif

                        @elseif($key == 'type')
                            @if($item->type == 'entry')
                                Приход
                            @else
                                Расход
                            @endif
                        @elseif($key == 'agent->title')
                            {{$item->agent->title ?? ''}}
                        @elseif($key == 'application->payment_type' && isset($item->application))
                            {{$item->application->payment_type ?? ''}}

                        @elseif($key == 'application->plan->price_arrival' && isset($item->application))
                            {{$item->application->plan->price_arrival ?? 0}}

                        @elseif($key == 'application->plan->price_sell' && isset($item->application))
                            {{$item->application->plan->price_sell ?? 0}}

                        @elseif($key == 'simcard->ssid' && isset($item->application))
                            {{$item->simcard->ssid ?? ''}}

                        @elseif($key == 'application->date_start' && isset($item->application))
                            {{date('d-m-Y',strtotime($item->application->date_start ?? ''))}}

                        @elseif($key == 'application->date_finish' && isset($item->application))
                            {{date('d-m-Y',strtotime($item->application->date_finish ?? ''))}}

                        @elseif($key == 'created_at')
                            {{date('d-m-Y H:i:s',strtotime($item->created_at ?? ''))}}

                        @elseif($key == 'application->plan->region_group->name' && isset($item->application))
                            {{$item->application->plan ? $item->application->region_group ? $item->application->region_group->name : '' : ''}}

                        @elseif($key == 'application->plan->name' && isset($item->application))
                            {{$item->application->plan->name ?? ''}}

                        @elseif($key == 'message')
                            {{$item->message ?? ''}}

                        @elseif($key == 'application->plan->provider->name' && isset($item->application))
                            {{$item->application->plan->provider->name ?? ''}}

                        @elseif($key == 'application->customer->name' && isset($item->application))
                            {{$item->application->customer->full_name ?? ''}}<br>
                            {{$item->application->customer->phone ?? ''}}

                        @elseif($key == 'application->user->name' && isset($item->application))
                            {{$item->application->user->name ?? ''}}

                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
