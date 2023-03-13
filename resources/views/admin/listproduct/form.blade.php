<div class="mb-3">
    <label for="">Название Товара</label>
    <input class="form-control" type="text" name="name" placeholder="Название Товара" value="{{old('name') ?? $listproduct->name ?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Описание</label>
    <input class="form-control" type="text" name="desc" placeholder="Описание товара" value="{{old('desc') ?? $listproduct->desc ?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Цена прихода</label>
    <input class="form-control" type="number" name="price_1" placeholder="Цена прихода" value="{{old('price_1') ?? $listproduct->price_1 ?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Цена Продажи usd</label>
    <input class="form-control" type="number" name="price_2" placeholder="Цена продажи" value="{{old('price_2') ?? $listproduct->price_2?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Цена Продажи uzs</label>
    <input class="form-control" type="number" name="price_3" placeholder="Цена продажи" value="{{old('price_3') ?? $listproduct->price_3?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Кол-во товара</label>
    <input class="form-control" type="number" name="count" placeholder="Кол-во товара" value="{{old('count') ?? $listproduct->count ?? ''}}" required>
</div>
