@extends('layouts.admin')
@section('title','Регионы')

@section('content')
<!-- Page-Title -->
<div class="row">
	<div class="col-md-12">
		<form method="GET" action="{{route('admin.plan.index')}}">
				<div class="input-group mb-3">
                    <input type="text" value="{{ request()->key ?? ''}}" name="key" class="form-control" placeholder="Название | Описание  | Регион" aria-label="Название | Описание  | Регион" aria-describedby="button-addon2">
                    <button class="btn btn-secondary" type="submit" id="button-addon2">Поиск</button>
                </div>
		</form>
	
	</div>

    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <div>
                    <h4 class="card-title">{{strtoupper(request()->type ?? 'Normal')}} Тарифы</h4>
                    <p class="text-muted mb-0 fw-semibold">Количество: {{$plans->total()}}</p>
                    <p class="text-muted mb-0">Здесь вы можете увидеть все {{strtoupper(request()->type ?? 'Normal')}} Тарифы <a href="{{route('admin.plan.create')}}" class="btn btn-success float-end">Создать</a>
                    </p>
                </div>
            </div>
            <div class="card-body min-height-350">
                <div class="table-responsive">
                    <table class="table mb-0 table-centered table-hovered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Регион</th>
                                <th>Срок действия</th>
                                <th>Цена прихода</th>
                                <th>Цена продажи</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $data)
                            <tr class="cursor-pointer" ondblclick="window.location.href='{{route('admin.plan.edit',$data->id)}}'">
                                <th>{{($plans ->currentpage()-1) * $plans ->perpage() + $loop->index + 1 }}</th>
                                <td>{{$data->region_group->name ?? ''}}</td>
                                <td>{{$data->name ?? ''}}</td>
                                <td>
                                @foreach($data->regions as $item)
                                    {{$item->name ?? ''}}<br>
                                @endforeach
                                </td>
                                <td>{{$data->expiry_day ?? ''}} дней</td>
                                <td>{{$data->price_arrival ?? ''}} UZS</td>
                                <td>{{$data->price_sell ?? ''}} UZS</td>
                                <td class="text-end">
                                    <form id="form{{$data->id}}" action="{{route('admin.plan.destroy',$data->id)}}" method="post" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v font-20 text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                            <a class="dropdown-item" href="{{route('admin.plan.edit',$data->id)}}">Изменить</a>
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
               {!! $plans->appends(Request::except('page'))->render() !!}
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
