<div class="modal fade" id="applicationFilterModal" tabindex="-1" role="dialog" aria-labelledby="applicationFilterModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalDefaultLabel">Фильтр</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('admin.application.index',request()->status ?? '')}}" id="filter">
                            @if(auth()->user()->role != 'agent')
                            <div class="mb-3">
                                <label for="">Агент</label>
                                <select name="agent_id" class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach ($agents ?? [] as $item)
                                    <option value="{{$item->id}}" @if((isset(request()->agent_id) && request()->agent_id == $item->id) ) selected @endif>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="">Ползователь</label>
                                <select name="user_id" class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach ($users ?? [] as $item)
                                    <option value="{{$item->id}}" @if((isset(request()->user_id) && request()->user_id == $item->id) ) selected @endif>{{$item->name ?? ''}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
							
                           <div class="mb-3">
                           <label>Статусь</label>
                           	  <select name="filter_status" id=""  class="form-control">
                                <option value="">Выбрать</option>
                                <option value="cancel">Отмененный</option>
                                <option value="accepted">Активные</option>
                                <option value="new">Новый</option>
                                <option value="additional">Дополнительный</option>
                            </select>
                           </div>
                        </form>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Закрыть</button>
                <a href="{{route('admin.application.index',request()->status)}}" class="btn btn-info btn-sm">Очистить фильтр</a>
                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('filter').submit()">Филтер</button>
            </div>
            <!--end modal-footer-->
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
