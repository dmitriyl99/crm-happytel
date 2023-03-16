@extends('layouts.admin')
@section('title','Сим карты')

@section('content')
    <!-- Page-Title -->
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <!--                 <a href="{{route('admin.simcard.change.agent')}}" class="btn btn-warning btn-sm">Сменить агента</a> -->

                    <a href="{{route('admin.simcard.index')}}" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                       data-bs-target="#exampleModalDefault">Филтер</a>
                    <a href="{{route('admin.simcard.create.mass')}}" class="btn btn-success btn-sm">Добавить
                        симкарты</a>
                    <a href="{{route('admin.simcard.index')}}" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                       data-bs-target="#importBlade">Импортировать симкарты</a>
                    <div class="modal fade" id="importBlade" tabindex="-1" role="dialog" aria-labelledby="importLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form class="modal-content" action="{{route('admin.simcard.import.mass')}}" id="import"
                                  enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h6 class="modal-title m-0" id="importLabel">Импортировать симкарты</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <!--end modal-header-->
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label>Агент</label>
                                                <select class="form-control" name="agent_id">
                                                    <option value="" disabled selected>Выбирать</option>
                                                    @forelse($agents as $key => $item)
                                                        <option value="{{$item->id}}">{{$item->title ?? ''}}</option>
                                                    @empty

                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label>Регион группа</label>
                                                <select id="countryMultiSelect" name="region_groups[]" multiple  required>
                                                    @forelse($region_groups as $key => $item)
                                                        <option value="{{$item->id}}">{{$item->name ?? ''}}</option>
                                                    @empty

                                                    @endforelse
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="excel">Выберите файл</label>
                                                <input type="file" name="file" class="custom-file-input form-control"
                                                       id="excel">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </div>
                                <!--end modal-body-->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">
                                        Закрыть
                                    </button>
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm">Загрузить
                                    </button>
                                </div>
                                <!--end modal-footer-->
                            </form>
                            <!--end modal-content-->
                        </div>
                        <!--end modal-dialog-->
                    </div>
                    <!--end modal-->


                    @include('admin.simcard.filter')
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div>
                        <h4 class="card-title">Сим карты</h4>
                        <p class="text-muted mb-0 fw-semibold">Количество: {{$simcards->total()}}</p>
                        <p class="text-muted mb-0">Здесь вы можете увидеть все Сим карты

                        </p>
                    </div>
                </div>
                <div class="card-body min-height-350">
                    <div class="table-responsive">
                        <table class="table mb-0 table-centered min-heght-200 table-sm">
                            <thead>
                            <tr>
                                <th></th>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>ICCID</th>
                                <th>Регион группа</th>
                                <th>Агент</th>
                                <th>Цена</th>
                                <th class="text-end"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($simcards as $data)
                                <tr>
                                    <th>{{($simcards ->currentpage()-1) * $simcards ->perpage() + $loop->index + 1 }}</th>
                                    <th><input type="checkbox" class="table-checkbox" value="{{$data->id}}"></th>
                                    <td>{{$data->ssid ?? ''}}</td>

                                    <td>
                                        @foreach($data->region_groups as $key => $item)
                                            {{$item->name ?? ''}}<br>
                                        @endforeach
                                    </td>
                                    <td>{{$data->agent->title ?? ''}}</td>
                                    <td>{{$data->price ?? ''}}</td>
                                    @if(auth()->user()->role != 'agent')
                                        <td class="text-end">

                                            <form id="form{{$data->id}}"
                                                  action="{{route('admin.simcard.destroy',$data->id)}}" method="post"
                                                  class="d-none">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            <div class="dropdown d-inline-block">

                                                <a class="dropdown-toggle arrow-none" id="dLabel11"
                                                   data-bs-toggle="dropdown" href="#" role="button"
                                                   aria-haspopup="false" aria-expanded="false">
                                                    <i class="las la-ellipsis-v font-20 text-muted"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                                    <a class="dropdown-item"
                                                       href="{{route('admin.simcard.edit',$data->id)}}">Изменить</a>
                                                    <a class="dropdown-item" href="javascript:;"
                                                       onclick="confirm('Вы уверены, что удалите его?') ? document.getElementById('form{{$data->id}}').submit() : false">Удалить</a>
                                                </div>
                                            </div>

                                        </td>
                                    @endif
                                    <td>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <!--end /table-->
                    </div>
                    <!--end /tableresponsive-->
                    <div class="mb-3"></div>
                    {{$simcards->links()}}
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $(document).on("click", "#checkAll", function () {
                $('.table-checkbox:checkbox').not(this).prop('checked', this.checked)
            });
            $(document).on('click', '#changeAgent', function () {
                var selected = '';
                $(".table-checkbox:checked").each(function () {
                    selected += $(this).val() + ',';
                });
                if (selected == '') {
                    return alert('Выбранная строка не найдена. Выберите одну или несколько строк, после чего вы сможете изменить агента.');
                }
                $('#selected_simcard_id').val(selected);
            });
        });

    </script>
    <script>
        customToggleDiv('#regionDiv');
        customToggleDiv('#planDiv');
        new Selectr('#countryMultiSelect', {
            multiple: true
        });

        $(":input").keypress(function(event){
            if (event.which == '10' || event.which == '13') {
                event.preventDefault();
            }
        });

    </script>
@endsection
