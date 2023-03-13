@extends('layouts.admin')
@section('title','Разрешение')

@section('content')
<!-- Page-Title -->
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Список разрешений <span><a href="{{route('admin.permission.create')}}" class="btn btn-success float-end">Создать</a></span></div>
            <div class="card-body">
                
                @can('create post')
                Test
                @endcan
                <table class="table table-stripped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Префикс</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $key => $permission)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$permission->title ?? ''}}</td>
                            <td>{{$permission->name ?? ''}}</td>
                            <td>
                                <a href="{{route('admin.permission.edit',$permission->id)}}" class="btn btn-warning">Редактировать</a>
                                <a href="javascript:;" class="btn btn-danger" onclick="confirm('Уверены ли вы') ? document.getElementById('permissionRemove{{$permission->id}}').submit() : false">Удалить</a>
                                <form style="display:none" method="POST" action="{{route('admin.permission.destroy',$permission->id)}}" id="permissionRemove{{$permission->id}}">
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
