@extends('layouts.admin')
@section('title','Агенты')

@section('content')
<!-- Page-Title -->
<div class="row">

    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <div>
                    <h4 class="card-title">Агенты</h4>
                    <p class="text-muted mb-0">Здесь вы можете увидеть все Агенты <a href="{{route('admin.agent.create')}}" class="btn btn-success float-end">Создать</a>
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-centered">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Емаил"</th>
                                <th>Телефон</th>
                                <th>Статус</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Agent 1</td>
                                <td>test@test.com</td>
                                <td>+998946153095<br>+9989461500000</td>
                                <td><span class="badge badge-success">Активный</span></td>
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
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection
