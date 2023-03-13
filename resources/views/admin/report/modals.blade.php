<div class="modal fade" id="columnFormModal" tabindex="-1" role="dialog" aria-labelledby="columnFormModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="columnFormModal">Форма оплаты</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>Выберите, какой столбец вы хотите показать</p>
                        <form action="{{route('column.update')}}" id="columnForm" method="POST">
                            @csrf
                            <input type="hidden" name="table" value="{{$table ?? ''}}">
                            <div class="mb-3">
                                <input type="checkbox" id="checkAllCheckbox">
                                <label id="labelCheckAll" for="checkAllCheckbox">Выбрать все</label>
                            </div>
                            @foreach($columns as $key => $column)
                                <div class="mb-2">
                                    <input 
                                    class="customColumn" 
                                    type="checkbox" 
                                    name="column[{{$key}}]" 
                                    id="checkbox{{$key}}" 
                                    @if(in_array($key,session()->get($table) ?? [])) checked @endif
                                    >
                                    <label for="checkbox{{$key}}">{{$column}}</label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('columnForm').submit()">Сохранить</button>
            </div>
            <!--end modal-footer-->
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
