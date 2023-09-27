<div class="">
    @if($selectedCustomer)
    <input type="hidden" name="customer_id" value="{{$selectedCustomer['id'] ?? ''}}">
    <div class="card mb-3 " style="border: 1px dotted;">
        <div class="card-body">
            <div style="position: absolute; right: 15px;">
                <a href="javascript:;" wire:click="resetAll()">Изменить</a><br>
                <a href="{{route('admin.customer.edit',$selectedCustomer['id'])}}" target="_blank">Показать</a>
            </div>
            <div class="mb-2 ">
                <div class="mb-2 text-secondary">ФИО</div>
                {{$selectedCustomer['full_name'] ?? ''}}
            </div>

            <div class="mb-2 ">
                <div class="text-secondary">Телефон</div>
                {{$selectedCustomer['phone'] ?? ''}}
            </div>

            <div class="mb-2 ">
                <div class="text-secondary">Билет</div>
                {{$selectedCustomer['ticket'] ?? 'Нету'}}
            </div>
            <div class="mb-2 ">
                <a href="{{$selectedCustomer['passport']}}" target="_blank">Показать паспорт</a>
            </div>

        </div>
    </div>
    @endif
    @if(!$selectedCustomer)
    <div class="form-group customSelectOption mb-3">
        <span style=""><i class="fas fa-angle-down"></i></span>
        <label for="">ФИО</label>
        <input placeholder="ФИО" type="text" class="form-control" name="full_name" wire:model.debounce.500ms="customer" wire:click="$set('dropmenu',true)" autocomplete="off">
        @if($dropmenu)
        <div class="card" id="nameDiv">
            <ul class="list-group">
                @foreach($customers as $item)
                <li wire:click="selectedItem({{$item}})" class="list-group-item list-group-item-action">
                    <i class="la la-arrow-right text-secondary me-2"></i>
                    {{$item->full_name ?? ''}} - {{$item->phone ?? ''}}

                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <div class="mb-3">
        <label for="">Телефон</label>
        <input class="form-control" type="text" name="phone" placeholder="Телефон" wire:model.debounce.5000ms="phone">
    </div>
    <div class="mb-3">
        <label for="">Пасспорт</label>
        <input type="file" name="passport" class="form-control" @if(request()->status == "new") required @endif>
    </div>

    <div class="mb-3">
        <label for="">Билет</label>
        <input class="form-control" type="text" name="ticket" placeholder="Билет">
    </div>
    @endif
</div>
