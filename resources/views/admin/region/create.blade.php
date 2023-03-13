@extends('layouts.admin')
@section('title','Создать регион')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Создать регион</div>
            <div class="card-body">
                <form action="{{route('admin.region.store')}}" method="post">
                    @csrf
                    @include('admin.region.form')
                    <div class="mb-3">
                        <button class="btn btn-success" type="submit">Сохранить</button>
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
