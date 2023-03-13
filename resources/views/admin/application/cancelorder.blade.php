<div class="modal fade" id="cancelOrdersModal{{$data->id ?? ''}}" tabindex="-1" role="dialog" aria-labelledby="cancelOrdersModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="cancelOrdersModal">Отменить заказ форму</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('admin.application.status.confirm')}}" id="changeApplicationStatus" method="POST">
                            @csrf
                            <input type="hidden" id="selected_appliaction_id" name="ids">
                            <h3>Да, я подтверждаю эти заказы</h3>
                        </form>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('changeApplicationStatus').submit()">Подтвердить</button>
            </div>
            <!--end modal-footer-->
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>