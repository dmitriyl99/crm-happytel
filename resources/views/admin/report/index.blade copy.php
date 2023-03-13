@extends('layouts.admin')
@section('title','Роли')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Сим карты</h4>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="chart-demo">
                    <div id="apex_bar" class="apex-charts"></div>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Турагенты</h4>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="chart-demo">
                    <div id="apex_mixed" class="apex-charts"></div>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h4 class="card-title">Турфгенты</h4>
                    <p class="text-muted mb-0">Здесь вы можете увидеть все Турагенты

                    </p>
                </div>
            </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-centered">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="https://happytel.uz/img/uploads/country/flag/cR7_iFVhOh334bszgrF-Vj5XdkMEYlYD.png" alt="" class=" thumb-xs me-1" style="height: 32px!important;width: 50px!important;">
                                    Турция
                                </td>
                                <td class="text-end">
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v font-20 text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                            <a class="dropdown-item" href="#">Изменить</a>
                                            <a class="dropdown-item" href="#">Удалить</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <img src="https://happytel.uz/img/uploads/country/flag/HkuTx-BMX-ndsO8v_qK0fGO4zGfsXSkC.png" alt="" class="thumb-xs me-1" style="height: 32px!important;width: 50px!important;">
                                    Великобритания
                                </td>
                                <td class="text-end">
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v font-20 text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                            <a class="dropdown-item" href="#">Изменить</a>
                                            <a class="dropdown-item" href="#">Удалить</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <img src="https://happytel.uz/img/uploads/country/flag/3Pv3qFsP-6n9L1ShepSTGuR7Di363Tby.png" alt="" class="thumb-xs me-1" style="height: 32px!important;width: 50px!important;">
                                    ОАЭ
                                </td>
                                <td class="text-end">
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v font-20 text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                            <a class="dropdown-item" href="#">Изменить</a>
                                            <a class="dropdown-item" href="#">Удалить</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                         
                        </tbody>
                    </table>
                    <!--end /table-->
                </div>
                <!--end /tableresponsive-->
            </div>
            <!--end card-body-->
        </div>
    </div>
</div>

<!--end row-->
<!-- end page title end breadcrumb -->
@endsection

@section('js')
<script src="{{asset('assets/plugins/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/plugins/apexcharts/irregular-data-series.js')}}"></script>
<script src="{{asset('assets/plugins/apexcharts/ohlc.js')}}"></script>
<script src="{{asset('assets/pages/apexcharts.init.js')}}"></script>

@endsection
