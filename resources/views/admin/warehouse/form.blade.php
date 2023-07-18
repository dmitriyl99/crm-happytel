<div class="mb-3">
    <label for="product_name">Название товара</label>
    <input class="form-control" list="products" name="name" id="name">
    <datalist id="products">
        @foreach($products as $product)
            <option value="{{$product->name}}">
        @endforeach
    </datalist>
</div>

<div class="mb-3">
    <label for="">Описание</label>
    <input class="form-control" type="text" name="desc" placeholder="Описание товара"
           value="{{old('desc') ?? $product->desc ?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Цена прихода</label>
    <input class="form-control" type="number" name="price_1" placeholder="Цена прихода" value="{{old('price_1') ?? $product->price_1 ?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Цена Продажи usd</label>
    <input class="form-control" type="number" name="price_2" placeholder="Цена продажи" value="{{old('price_2') ?? $product->price_2?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Цена Продажи uzs</label>
    <input class="form-control" type="number" name="price_3" placeholder="Цена продажи" value="{{old('price_3') ?? $product->price_3?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Кол-во товара</label>
    <input class="form-control" type="number" name="count" placeholder="Кол-во товара" value="{{old('count') ?? $product->count ?? ''}}" required>
</div>
<div class="mb-3">
    <label for="">Штрих Код</label>
    <input class="form-control" type="text" name="barcode" placeholder="Штрих Код (barcode)" value="{{old('barcode') ?? $product->barcode ?? ''}}">
</div>
