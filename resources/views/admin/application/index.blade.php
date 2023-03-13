@extends('layouts.admin')
@section('title','Заявки')

@section('content')
<!-- Page-Title -->
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @if(auth()->user()->isUser())
                <form action="">
                    @if(request()->status == 'new' || request()->status == 'cancel')
                    <a href="javascript:;" class="btn btn-success btn-sm" id="confirmOrders">Confirm order</a>
                    @endif
                    @if(request()->status == 'new' || request()->status == 'accepted')
                    <a href="javascript:;" class="btn btn-danger btn-sm" id="cancelOrders">Cancel Order</a>
                    @endif
                    @if(request()->status == 'new')
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="">Activation date</label>
                            <input class="form-control" type="date" name="date_start" value="{{request()->date_start ? date('Y-m-d',strtotime(request()->date_start)) : ''}}">
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">
                       Filter
                    </button>
                    <a href="{{route('admin.application.index',request()->status ?? 'new')}}">Clear</a>
                    @endif
                </form>
                @else
                @if(auth()->user()->isAdmin() || auth()->user()->isUser())
                <a href="javascript:;" class="btn btn-success btn-sm" id="confirmOrders">Подтвердить заявки</a>
                @endif
                @if(auth()->user()->isAdmin() || request()->status == 'new')
                <a href="javascript:;" class="btn btn-danger btn-sm" id="cancelOrders">Отменить заказы</a>
                @endif
                @endif
                @if(auth()->user()->isUser())
                @else
                <button class="btn btn-primary btn-sm" id="applicationFilter" data-bs-toggle="modal" data-bs-target="#applicationFilterModal">Фильтр</button>
                @endif
            </div>
        </div>
        @include('admin.application.filter')
        @livewire('application-list', ['status' => request()->status ?? 'new'])
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->

@include('admin.application.changeagent')
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $(document).on("click", "#checkAll", function() {
            $('.table-checkbox:checkbox').not(this).prop('checked', this.checked)
        });
        $(document).on('click', '#confirmOrders', function() {
            var selected = '';
            $(".table-checkbox:checked").each(function() {
                selected += $(this).val() + ',';
            });
            if (selected == '') {
                return alert('Выбранная строка не найдена');
            }
            $('#confirmOrdersModal').modal('show');
            $('#selected_appliaction_id').val(selected);
        });


        $(document).on('click', '#cancelOrders', function() {
            var selected = '';
            $('#orderIdsText').html('');

            $(".table-checkbox:checked").each(function() {
                selected += $(this).val() + ',';
                $('#orderIdsText').append($(this).val() + ' - ')
            });

            if (selected == '') {
                return alert('Выбранная строка не найдена');
            }
            $('#cancelOrdersModal').modal('show');
            $('#cancel_application_ids').val(selected);


        });
    });
</script>
@endsection