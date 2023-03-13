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
                        <form action="{{route('admin.newp.index')}}" id="filter">  
                        <div class="mb-3">
                            <label for="">Название товара</label>
                            <select name="product_id" class="form-control" id="product_id">
                                <option value="">Выбрать</option>
                                @foreach($lists  as $item)
                                    <option value="{{$item->id ?? ''}}" @if(isset($newps) && $newps->product_id == $item->id) selected @endif>{{$item->name ?? ''}}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="mb-3">
                                <label for="">Вид платежа</label>
                                    @foreach(getPaymentTypes() as $item)
                                    <div class="col-md-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="payment_type" type="radio" id="{{$item->key ?? ''}}" value="{{$item->key ?? ''}}" 
                                            @if((old('payment_type') == $item->key) || (isset($newps->payment_type)  && $newps->payment_type  == $item->key)) checked @endif  >
                                            <label class="form-check-label" for="{{$item->key ?? ''}}">{{$item->value ?? ''}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            <!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Закрыть</button>
                <a href="{{route('admin.newp.index',request()->product_id)}}" class="btn btn-info btn-sm">Очистить фильтр</a>
                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('filter').submit()">Филтер</button>
            </div>
            <!--end modal-footer-->
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
