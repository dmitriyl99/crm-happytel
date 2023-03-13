<div class="modal fade" id="paymentFormModal" tabindex="-1" role="dialog" aria-labelledby="paymentFormModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="changeAgentModalDefault">Форма оплаты</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>Здесь вы можете определить оплаченную сумму Агента</p>
                        <form action="{{route('admin.provider.pay')}}" id="paymentForm" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="">Поставшик</label>
                                <select name="provider_id" class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach ($providers as $item)
                                    <option value="{{$item->id}}" >{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="">Сумма</label>
                                <input type="text" class="form-control" name="sum" placeholder="Сумма">
                            </div>
                            
                            <div class="mb-3">
                                <label for="">Дата</label>
                                <input class="form-control" name="payment_date" type="date" placeholder="Дата">
                            </div>

                        </form>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('paymentForm').submit()">Сохранить</button>
            </div>
            <!--end modal-footer-->
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
