

@extends('layouts.admin')
@section('title','Изменить Статусы')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Изменить Статусы</div>
            <div class="card-body">
                <form action="{{route('admin.update.status')}}" method="post">
                    @csrf
                    @method('PUT')
                   
                    <div class="mb-3">
                        <label for="">Статусы</label>
                        <input class="form-control" type="text" name="buy_simcard" value="{{old('buy_simcard') ?? Config::get('a_status')['buy_simcard'] ?? ''}}" required>
                        <br>
                        {{--<input class="form-control" type="text" name="refound" value="{{old('refound') ?? Config::get('a_status')['refound'] ?? ''}}" required>
                        <br>
                        <input class="form-control" type="text" name="new_order" value="{{old('new_order') ?? Config::get('a_status')['new_order'] ?? ''}}" required>
                        <br>--}}
                        <input class="form-control" type="text" name="order_accepted" value="{{old('order_accepted') ?? Config::get('a_status')['order_accepted'] ?? ''}}" required>
                        <br>
                        <input class="form-control" type="text" name="cancelled" value="{{old('cancelled') ?? Config::get('a_status')['cancelled'] ?? ''}}" required>
                        <br>
                        <input class="form-control" type="text" name="added_other_plan" value="{{old('added_other_plan') ?? Config::get('a_status')['added_other_plan'] ?? ''}}" required>
                        <br>

                        <input class="form-control" type="text" name="balance_filled" value="{{old('balance_filled') ?? Config::get('a_status')['balance_filled'] ?? ''}}" required>
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





