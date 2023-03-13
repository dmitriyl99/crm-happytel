<div class="mb-3">

    <div class="form-group customSelectOption mb-3">
        <span><i class="fas fa-angle-down"></i></span>
        <label for="">Страны </label>
        @if(empty($items) || $items->count() == 0)<i class="text-danger"> - Нет данных для отображения</i>@endif
        <br>

        <input type="text" class="form-control" wire:model.debounce.500ms="item" wire:click="$set('dropmenu',true)">
        @if($dropmenu)
        <div class="card" id="countryDiv">
            <ul class="list-group">
                @foreach($items as $item)
                @if(!in_array($item->name, $selectedItems))
                <li wire:click="selectedItem('{{$item->id}}','{{$item->name}}')" class="list-group-item list-group-item-action">
                    <i class="la la-arrow-right text-secondary me-2 "></i>
                    {{$item->name ?? ''}}
                </li>
                @endif
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    @if(!empty($selectedItems))
    <table class="table table-sm mb-0">
        <thead class="thead-light">
            <tr>
                <td colspan="3">Выбранные страны</td>
            </tr>
        </thead>
        <tbody>
            @foreach($selectedItems as $key => $item)
            <input type="hidden" name="regionIds[]" value="{{$key}}">
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item}}</td>
                <td><a href="javascript:;" class="btn btn-danger btn-sm float-end"  wire:click="removeItemFromSelected({{$key}})">X</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
