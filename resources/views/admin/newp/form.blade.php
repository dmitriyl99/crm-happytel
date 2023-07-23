<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            @livewire('form.barcode-livewire-component')
        </div>
        <div class="mb-3">
            <label for="">Название товара</label>
            <select name="product_id" class="form-control" id="product_id">
                <option value="">Выбрать</option>
                @foreach($lists as $item)
                <option value="{{$item->id ?? ''}}" @if(isset($newp) && $newp->product_id == $item->id) selected @endif>{{$item->name ?? ''}} --- {{$item->count ?? ''}}ta --- {{number_format($item->price_3, 0, ',', ' ') ?? ' '}} UZS --- {{number_format($item->price_2, 0, ',', ' ') ?? ' '}} USD</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="">Кол-во товара</label>
            <input type="count" class="form-control" id="count" name="count" value="{{$newp->count ?? ''}}">
        </div>
        @if(!isset($newp->id))
        <div class="mb-3">
            <a href="javascript:;" class="btn btn-primary" id="add-product">Добавить товара</a>
        </div>
        @endif
        <hr>
        <div class="mb-3">
            <div class="col-md-6">
                @livewire('form.name-livewire-component',[
                'customerId' => old('customer_id') ?? $application->customer->id ?? '',
                'full_name' => old('full_name') ?? '',
                'ticket' => old('ticket') ?? '',
                'phone' => old('phone') ?? ''
                ])
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                @foreach(getPaymentTypes() as $item)
                <div class="col-md-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="payment_type" type="radio" id="{{$item->key ?? ''}}" value="{{$item->key ?? ''}}" @if((old('payment_type')==$item->key) || (isset($newp->payment_type) && $newp->payment_type == $item->key)) checked @endif >
                        <label class="form-check-label" for="{{$item->key ?? ''}}">{{$item->value ?? ''}}</label>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            @livewire('form.newp-list')
        </div>
    </div>


</div>

@section('js')
<script>
    customToggleDiv('#countDiv');
    customToggleDiv('#productDiv');
    new Selectr('#product_id', {
        multiple: false
    });
    $(document).on('change', '#product_id', function() {
        Livewire.emit('product_id_changed', $(this).val());
    });

    $(document).ready(function() {
        Livewire.on('add-product', () => {
            $('#product_id  option:first').attr("selected", "selected");
        });
    });

    $(document).on('click', '#add-product', function() {
        var product_id = $('#product_id').val();
        var count = $('input[name="count"]').val();
        if (!product_id) {
            alert('Укажите Название товара  ');
        } else if (!count) {
            alert('Укажите кол-во');
        } else {
            Livewire.emit('add-product', {
                product_id: product_id,
                count: count
            });
        }
    });
</script>
@endsection
