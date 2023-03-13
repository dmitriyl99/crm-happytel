@extends('layouts.admin')
@section('title','Пользователи')

@section('content')
<!-- Page-Title -->
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Список Пользователи <span><a href="{{route('admin.user.create')}}" class="btn btn-success float-end">Создать</a></span></div>
            <div class="card-body">
                <table class="table table-stripped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>ФИО</th>
                            <th>Логин</th>
                            <th>Ролы</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $key => $user)
                        <tr class="cursor-pointer" ondblclick="window.location.href='{{route('admin.user.edit',$user->id)}}'">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$user->name ?? ''}}</td>
                            <td>{{$user->email ?? ''}}</td>
                            <td>{{$user->role ?? ''}}</td>
                            <td>{{$user->agent->title ?? ''}}</td>
                            <td>
                                <a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-warning">Редактировать</a>
                                <a href="javascript:;" class="btn btn-danger" onclick="confirm('Уверены ли вы') ? document.getElementById('permissionRemove{{$user->id}}').submit() : false">Удалить</a>
                                <form style="display:none" method="POST" action="{{route('admin.user.destroy',$user->id)}}" id="permissionRemove{{$user->id}}">
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
