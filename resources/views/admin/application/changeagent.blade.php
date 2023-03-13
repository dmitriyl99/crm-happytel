<div class="modal fade" id="confirmOrdersModal" tabindex="-1" role="dialog" aria-labelledby="confirmOrdersModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="confirmOrdersModal">Подтвердить форму</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('admin.application.status.confirm')}}" id="changeApplicationStatus" method="POST">
                            @csrf
                            <input type="hidden" id="selected_appliaction_id" name="ids">
                            <input type="hidden" value="accepted" name="status">
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
<!--end modal-->


<div class="modal fade" id="cancelOrdersModal" tabindex="-1" role="dialog" aria-labelledby="cancelOrdersModal" aria-hidden="true">
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
                        <form action="{{route('admin.application.status.confirm')}}" id="cancelApplicationForm" method="POST">
                            @csrf
                            <input type="hidden" id="cancel_application_ids" name="ids">
                            <input type="hidden" name="status" value="cancel">
                            <input type="hidden" value="cancel" name="status">
                            <div class="mb-2">
                                <label for="">Почему вы отменяете ?</label>
                                <input placeholder="Причина..." type="text" class="form-control" name="comment" required>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('cancelApplicationForm').submit()">Отправить</button>
            </div>
            <!--end modal-footer-->
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
