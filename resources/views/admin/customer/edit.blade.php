@extends('layouts.admin')
@section('title','Изменить Клиент')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Изменить Клиент</div>
            <div class="card-body">
                <form action="{{route('admin.customer.update', $customer->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.customer.form')
                    <div class="mb-3">
                    <button class="btn btn-success" type="submit">Обновить</button>
                    <a class="btn" href="{{route('admin.customer.index')}}">Обратно к списку</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
