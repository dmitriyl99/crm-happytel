<div class="mb-3">
    <label for="">Поставшик</label>
    <select name="provider_id" class="form-control" required>
        <option value="">Выбрать</option>
        @foreach($providers  as $item)
            <option value="{{$item->id ?? ''}}" @if(old('provider_id') == $item->id || isset($plan) && $plan->provider != null && $item->id == $plan->provider->id ?? '') selected @endif>{{$item->name ?? ''}}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="">Название тарифа</label>
    <select name="region_group_id" class="form-control" required>
        <option value="">Выбрать</option>
        @foreach($region_groups  as $item)
            <option value="{{$item->id ?? ''}}" @if(old('region_group_id') == $item->id || isset($plan) && $plan->region_group_id == $item->id) selected @endif>{{$item->name ?? ''}}</option>
        @endforeach
    </select>
</div>


<div class="mb-3">
    <label for="">Описание тарифа</label>
    <input class="form-control" type="text" name="name" placeholder="Описание тарифа" value="{{old('name') ?? $plan->name ?? ''}}" required>
</div>

@livewire('form.country-multi-select-component',['itemIds' => old('regionIds') ?? (isset($plan) ? $plan->regions->pluck('id')->toArray() : [] )])

<div class="mb-3">
    <label for="">Срок действия</label>
    <input class="form-control" type="text" name="expiry_day" placeholder="Срок действия" value="{{old('expiry_day') ?? $plan->expiry_day ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Цена прихода</label>
    <input class="form-control" type="text" name="price_arrival" placeholder="Цена прихода" value="{{old('price_arrival') ?? $plan->price_arrival ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Цена продажи</label>
    <input class="form-control" type="text" name="price_sell" placeholder="Цена продажи" value="{{old('price_sell') ?? $plan->price_sell ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Цена $</label>
    <input class="form-control" type="text" name="price_user" placeholder="$" value="{{old('price_user') ?? $plan->price_user ?? ''}}">
</div>

<div class="mb-3">
    <label for="">Статус</label>
    <select name="status" class="form-control">
        @foreach (config('custom.status') as $key => $item)
            <option value="{{$key}}" @if((isset($plan) && $plan->status == $key) || old('status') == $key) selected @endif >{{$item}}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="">Тип</label>
    <select name="type" class="form-control">
        <option value="normal" @if(isset($plan->type) && $plan->type == 'normal') selected @endif>Обычный</option>
        <option value="additional" @if(isset($plan->type) && $plan->type == 'additional') selected @endif>Дополнительный</option>
    </select>
</div>


@section('js')
    <script>
           customToggleDiv('#countryDiv');
    </script>
@endsection



