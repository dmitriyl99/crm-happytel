@extends('layouts.admin')
@section('title','Роли')

@section('content')
<!-- Page-Title -->
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Список Роли <span><a href="{{route('admin.role.create')}}" class="btn btn-success float-end">Создать</a></span></div>
            <div class="card-body">
              
                <table class="table table-stripped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $key => $role)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$role->name ?? ''}}</td>
                            <td>
                                <a href="{{route('admin.role.edit',$role->id)}}" class="btn btn-warning">Редактировать</a>
                                <a href="javascript:;" class="btn btn-danger" onclick="confirm('Уверены ли вы') ? document.getElementById('remove{{$role->id}}').submit() : false">Удалить</a>
                                <form style="display:none" method="POST" action="{{route('admin.role.destroy',$role->id)}}" id="remove{{$role->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td>
                                Нет данных для отображения
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
