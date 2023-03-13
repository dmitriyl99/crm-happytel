@extends('layouts.admin')
@section('title','Изменить Пользователь')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Изменить Пользователь</div>
            <div class="card-body">
                <form action="{{route('admin.region.update', $region->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    @include('admin.region.form')
                    <div class="mb-3">
                    <button class="btn btn-success" type="submit">Обновить</button>
                    <a class="btn" href="{{route('admin.region.index')}}">Обратно к списку</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
