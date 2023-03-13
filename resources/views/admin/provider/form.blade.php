<div class="mb-3">
    <label for="">Название</label>
    <input class="form-control" type="text" name="name" placeholder="Название" value="{{old('name') ?? $provider->name ?? ''}}" required>
</div>
 
<div class="mb-3">
    <label for="">Номер контракт</label>
    <input class="form-control" type="text" name="contract_number" placeholder="Номер контракт" value="{{old('contract_number') ?? $provider->contract_number ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Дата контракт</label>
    <input class="form-control" type="text" name="contract_date" placeholder="Дата контракт" value="{{old('contract_date') ?? $provider->contract_date ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Оплата</label>
    <input class="form-control" type="text" name="payment" placeholder="Оплата" value="{{old('payment') ?? ''}}">
</div>

<div class="mb-3">
    <label for="">Баланс</label>
    <input class="form-control" type="text" name="balance" placeholder="Баланс" value="{{old('balance') ?? number_format($provider->balance  ?? '0')}} UZS" required readonly>
</div>



