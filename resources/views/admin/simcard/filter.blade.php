<div class="modal fade" id="exampleModalDefault" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefaultLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalDefaultLabel">Филтер</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('admin.simcard.index')}}" id="filter">
                            {{-- <div class="mb-3">
                                <label for="">Статус</label>
                                <select name="status" class="form-control">
                                    @foreach (config('custom.status') as $key => $item)
                                    <option value="{{$key}}" @if((isset(request()->status) && request()->status == $key)) @endif >{{$item}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            @if(auth()->user()->role != 'agent')
                            <div class="mb-3">
                                <label for="">Агент</label>
                                <select name="agent_id" class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach ($agents as $item)
                                    <option value="{{$item->id}}" @if((isset(request()->agent_id) && request()->agent_id == $item->id) ) selected @endif>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label for="">ICCID</label>
                                <input type="text" class="form-control" name="ssid" placeholder="ssid" value="{{request()->ssid ?? ''}}">
                            </div>
                            {{-- <div class="mb-3">
                                <label for="">Регион</label>
                                <select name="region_id" class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach ($regions as $item)
                                    <option value="{{$item->id}}" @if((isset(request()->region_id) && request()->region_id == $item->id)) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </form>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!--end modal-body-->
            <div class="modal-footer">
                <a href="{{route('admin.simcard.index')}}" class="btn btn-info btn-sm">Очистить фильтр</a>
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('filter').submit()">Филтер</button>
            </div>
            <!--end modal-footer-->
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
