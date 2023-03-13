

@extends('layouts.admin')
@section('title','Изменить настройки')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Изменить настройки</div>
            <div class="card-body">
                <form action="{{route('admin.update.global.settings')}}" method="post">
                    @csrf
                    @method('PUT')
                   
                    <div class="mb-3">
                        <label for="">Лимит баланса турагентов</label>
                        <input class="form-control" type="text" name="limit_balance" value="{{$settings['limit_balance']}}" required>
                        <br>
                    </div>


                    <div class="mb-3">
                    <button class="btn btn-success" type="submit">Обновить</button>
                   
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection





