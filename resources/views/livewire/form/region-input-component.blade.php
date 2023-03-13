<div>
    <div class="form-group customSelectOption mb-3" >
        <span><i class="fas fa-angle-down"></i></span>
        <label for="">Регион</label>
        <input type="hidden" name="region_id" wire:model="regionId">
        <input type="text" class="form-control" wire:model.debounce.500ms="region" wire:click="$set('dropmenu',true)">
        @if($dropmenu)
       <div class="card" id="regionDiv" >
            <ul class="list-group">
                @foreach($regions as $item)
                <li wire:click="selectedRegion({{$item->id}},'{{$item->name}}')" class="list-group-item list-group-item-action ">
                    <i class="la la-arrow-right text-secondary me-2"></i>
                    {{$item->name ?? ''}}
                </li>
                @endforeach
            </ul>
       </div>
       @endif
    </div>
</div>
