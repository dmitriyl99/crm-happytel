@extends('layouts.admin')
@section('title','Изменить Тариф')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Изменить Тариф</div>
            <div class="card-body">
                <form action="{{route('admin.plan.update', $plan->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    @include('admin.plan.form')
                    <div class="mb-3">
                    <button class="btn btn-success" type="submit">Обновить</button>
                    <a class="btn" href="{{route('admin.plan.index')}}">Обратно к списку</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
