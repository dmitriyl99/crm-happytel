<div>
    @if($errorMessage)
    <div class="alert alert-danger border-0" role="alert">
        <strong>{{$errorMessage}}</strong> 
    </div>
    @endif
    @foreach($paymentTypes as $key => $item)
    <div class="mb-2">
        <div class="row">
            <div class="col-2">
                <input type="text" class="form-control" placeholder="key" value="{{$item->key ?? ''}}">
            </div>
            <div class="col-8">
                <input type="text" class="form-control" placeholder="value" value="{{$item->value ?? ''}}">
            </div>
            <div class="col-2">
                <a class="btn btn-danger" href="javascript:;" wire:click="removeItem('{{$item->id}}')">X</a>
            </div>
        </div>
    </div>
    @endforeach

    <div class="mb-2">
        <div class="row">
            <div class="col-2">
                <input type="text" class="form-control" placeholder="key" wire:model.defer="paymentKey">
            </div>
            <div class="col-8">
                <input type="text" class="form-control" placeholder="value" wire:model.defer="paymentValue">
            </div>
            <div class="col-2">
                <a class="btn btn-success" href="javascript:;" wire:click="addNewItem()">+</a>
            </div>
        </div>
    </div>

</div>
