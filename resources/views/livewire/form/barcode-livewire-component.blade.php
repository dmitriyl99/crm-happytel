<div class="form-group">
    <label for="barcode">Штрих-код</label>
    <input type="text" id="barcode" class="form-control" placeholder="Поставьте указатель в это поле и отсканируйте штрих-код" wire:model.debounce.100ms="barcode" autocomplete="off">
</div>
