@extends('layouts.admin')
@section('title','Создать Заявка')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Создать Заявку</div>
            <div class="card-body">
                <form action="{{route('admin.application.store')}}" method="post"  enctype="multipart/form-data">
                    @csrf
                    @include('admin.application.form')
                    <div class="mb-3">
                        <button class="btn btn-success" type="submit">Сохранить</button>
                        <a class="btn" href="{{route('admin.application.index',request()->status)}}">Обратно к списку</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
