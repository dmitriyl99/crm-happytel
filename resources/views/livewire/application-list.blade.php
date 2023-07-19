<div>
    <div class="card">
        <div class="card-body">
            <input type="text" class="form-control" placeholder="SSID | Name " wire:model="searchedKey">
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div>
                @if(auth()->user()->isUser())
                    <h4 class="card-title">Orders</h4>
                    <p class="text-muted mb-0 fw-semibold">Count: {{$applications->total()}}</p>
                    </p>
                @else
                    <h4 class="card-title">Заявки</h4>
                    <p class="text-muted mb-0 fw-semibold">Количество: {{$applications->total()}}</p>
                    @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                        <p class="text-muted mb-0">Здесь вы можете увидеть все новый Заявки <a href="{{route('admin.application.create','new')}}" class="btn btn-success float-end">Создать новый</a>
                            @endif
                        </p>
                    @endif
            </div>
        </div>
        <div class="card-body min-height-350">
            <div class="table-responsive" style="min-height: 350px;">
                <table class="table mb-0 table-centered">
                    <thead>
                    <tr>
                        <th>
                            @if(request()->status != 'new')
                                <input type="checkbox" id="checkAll">
                            @endif
                        </th>
                        <th></th>
                        @if(auth()->user()->isUser())
                            <th>Fare type</th>
                            <th>Client</th>
                            <th>Created at</th>
                            <th>Status</th>
                            <th>Region Group</th>
                            <th>Tariff</th>
                            <th>Sim card</th>
                            <th>Activation date </th>
                            <th>Expiration date</th>
                            <th>Payment Type</th>
                        @else
                            <th>Тип тарифа</th>
                            <th>Kлиент</th>
                            <th>Дата создания</th>
                            <!--<th>Агент</th>-->
                            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                <th>Поставшик</th>
                                <th>Ползовател</th>
                            @endif
                            <th>Статус</th>
                            <th>Регион Группа</th>
                            <th>Тариф</th>
                            <th>Сим карт</th>
                            <th>Дата активации </th>
                            <th>Дата окончания </th>
                            <th>Оплата</th>
                        @endif
                        <th class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $data)
                        <tr>
                            <input type="hidden" name="app" value="{{$data}}">
                            <td><input type="checkbox" class="table-checkbox" value="{{$data->id}}"></td>
                            <td>{{($applications->currentpage()-1) * $applications->perpage() + $loop->index + 1 }}</td>
                            <td>
                                @if(auth()->user()->isUser())
                                    @if(isset($data->plan) && $data->plan->type == 'normal')
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
                            <td>
                                <a href="{{route('admin.customer.show',$data->customer->id ?? '')}}" target="_blank">
                                    {{$data->customer->full_name ?? ''}}
                                    {{$data->customer->phone ?? ''}}
                                </a><br>
                                @if($data->customer->passport ?? '')
                                    <a href="{{$data->customer->passport ?? ''}}" target="_blank">
                                        Пасспорт
                                    </a>
                                @endif
                                <br>
                            </td>
                            <td>{{date('d-m-Y H:i:s', strtotime($data->created_at ?? ""))}}</td>
                            <!--<td>{{$data->agent->title ?? ''}}</td>-->
                            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                <td>{{$data->plan->provider->name ?? ''}}</td>
                                <td>{{$data->user->name ?? ''}}</td>
                            @endif
                            <td>{{customStatusColor($data->status)}}</td>
                            <td>{{$data->plan ? $data->plan->region_group ? $data->plan->region_group->name : '-' : '-'}}</td>
                            <td>{{$data->plan->name ?? ''}}<br>
                                {{$data->plan->expiry_day ?? ''}} день <br>
                                @if(auth()->user()->isUser())
                                    {{($data->plan->price_user)}} $
                                @else
                                    {{number_format($data->plan->price_sell ?? 0)}}
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{$data->simcard->ssid ?? ''}}</span><br>
                            </td>
                            <td>{{customDate($data->date_start ?? '')}}</td>
                            <td>{{customDate($data->date_finish ?? '')}}</td>

                            <td>
                                {{$data->payment_type ?? ''}}
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
                                        <a class="dropdown-item" href="{{route('admin.application.additional',$data->id)}}">Добавить доп.план</a>
                                        {{-- <a class="dropdown-item" href="{{route('admin.application.show',$data->id)}}">Показать</a>--}}
                                        <a class="dropdown-item" href="{{route('admin.application.edit',$data->id)}}">Изменить</a>
                                        @if(auth()->user()->isSuperAdmin())
                                            <a class="dropdown-item" href="javascript:;" onclick="confirm('Вы уверены, что удалите его?') ? document.getElementById('form{{$data->id}}').submit() : false">Удалить</a>
                                        @endif
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
            {{$applications->links() }}
            {{--{!! $applications->appends(Request::except('page'))->render() !!}--}}
        </div>
        <!--end card-body-->
    </div>
</div>
