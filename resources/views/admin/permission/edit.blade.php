@extends('layouts.admin')
@section('title','Изменить разрешение')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Изменить разрешение</div>
            <div class="card-body">
                <form action="{{route('admin.permission.update', $permission->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    @include('admin.permission.form')
                    <div class="mb-3">
                    <button class="btn btn-success" type="submit">Обновить</button>
                    <a class="btn" href="{{route('admin.permission.index')}}">Обратно к списку</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
