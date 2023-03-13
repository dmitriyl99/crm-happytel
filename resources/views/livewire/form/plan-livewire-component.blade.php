<div>
    <div class="form-group customSelectOption mb-3">
        <span style=""><i class="fas fa-angle-down"></i></span>
        <label for="">Тариф</label>
        @if(empty($plans) || $plans->count() == 0)<i class="text-danger"> - Нет данных для отображения</i>@endif
        <input type="hidden" name="plan_id" wire:model="planId">
        <input type="text" class="form-control" wire:model.debounce.500ms="plan" wire:click="$set('dropmenu',true)">
        @if($dropmenu)
        <div class="card" id="planDiv">
            <ul class="list-group">
                @foreach($plans as $item)
                <li wire:click="selectedItem({{$item->id}},'{{$item->name}}')" class="list-group-item list-group-item-action">
                    <i class="la la-arrow-right text-secondary me-2"></i>
                    {{$item->name ?? ''}}
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
