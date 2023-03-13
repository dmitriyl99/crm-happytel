@extends('layouts.admin')
@section('title','Изменить Статусы')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Изменить Статусы</div>
            <div class="card-body">
                @foreach($paymentTypes as $key => $item)
                <div class="mb-2">
                    <div class="row">
                        <div class="col-2">
                            <input type="text" class="form-control" placeholder="key" value="{{$item->key ?? ''}}">
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" placeholder="value" value="{{$item->value ?? ''}}">
                        </div>
                        <div class="col-2">
                            <form action="{{route('admin.delete.payment.types',$item->id)}}" id="paymentTypeForm{{$item->id}}" method="POST">
                                @method('DELETE')
                                @csrf
                            </form>
                            <a class="btn btn-danger" href="javascript:;" onclick="document.getElementById('paymentTypeForm{{$item->id}}').submit()">X</a>
                        </div>
                    </div>
                </div>
                @endforeach

               

                <form action="{{route('admin.update.payment.types')}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-2">
                                <input type="text" class="form-control" placeholder="key" name="itemKey">
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" placeholder="value" name="itemValue">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-success" >+</button>
                            </div>
                        </div>
                    </div>
          
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
