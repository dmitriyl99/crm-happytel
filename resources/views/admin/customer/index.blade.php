@extends('layouts.admin')
@section('title','Клиенты')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
               
                <div>
                    <h4 class="card-title">Клиенты</h4>
                    <p class="text-muted mb-0 fw-semibold">Количество: {{$customers->total()}}</p>
                    <p class="text-muted mb-0">Здесь вы можете увидеть все Клиенты <a href="{{route('admin.customer.create')}}" class="btn btn-success float-end">Создать</a>
                    </p>
                </div>
            </div>
            <div class="card-body min-height-350">
                
                <div class="table-responsive">
                    <table class="table mb-0 table-centered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ФИО</th>
                                <th>Телефон</th>
                                <th>Статус</th>
                                <th>Пасспорт</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $data)
                            <tr class="cursor-pointer" ondblclick="window.location.href='{{route('admin.customer.edit',$data->id)}}'">
                                <td>{{($customers ->currentpage()-1) * $customers ->perpage() + $loop->index + 1 }}</td>
                                <td>{{$data->full_name ?? ''}}</td>
                                <td>{{$data->phone ?? ''}}</td>
                                <td>{{$data->status ?? ''}}</td>
                                <td><img src="{{$data->passport ?? ''}}" style="width: 40px"></td>

                                <td class="text-end">
                                    <form id="form{{$data->id}}" action="{{route('admin.customer.destroy',$data->id)}}" method="post" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v font-20 text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                            <a class="dropdown-item" href="{{route('admin.customer.edit',$data->id)}}">Изменить</a>
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
                {{$customers->links()}}
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
