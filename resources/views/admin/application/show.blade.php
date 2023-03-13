@extends('layouts.admin')
@section('title','')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="mb-3">
                    <h4><b>Агент:</b> <a href="{{route('admin.agent.show',$application->agent->id ?? 0)}}"> {{$application->agent->title ?? ''}}</a></h4>
                </div>
                <div class="mb-3">
                    <b>Страна:</b> {{$application->region->name ?? ''}}
                </div>
                <div class="mb-3">
                    <b>SSID:</b> {{$application->simcard->ssid ?? ''}}
                </div>
               
                <div class="mb-3">
                    <b>Тариф:</b> {{$application->plan->name ?? ''}}
                </div>
                <div class="mb-3">
                    <b>ФИО:</b> {{$application->customer->full_name ?? ''}}
                </div>
                <div class="mb-3">
                    <b>Телефон:</b> {{$application->customer->phone ?? ''}}
                </div>
                <div class="mb-3">
                    <a href="{{$application->customer->passport ?? ''}}" target="_blank">Пасспорт</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <a href="{{route('admin.application.index',$application->status ?? '')}}">
            Обратно к списку
        </a>
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
