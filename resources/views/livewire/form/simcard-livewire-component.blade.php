<div class="mb-3">
    @if(!empty($selectedSimcard))
    <table class="table table-sm mb-0">
        <thead class="thead-light">
            <tr>
                <td colspan="3">Выбранные симкарт</td>
            </tr>
        </thead>
        
        <tbody>
   
            <input type="hidden" name="simcard_id" value="{{$selectedSimcard->id ?? ''}}">
            <tr>
                <td>{{$selectedSimcard->id ?? ''}}</td>
                <td>{{$selectedSimcard->ssid ?? ''}}</td>
                <td><a href="javascript:;" class="btn btn-danger btn-sm float-end" wire:click="removeSimcardFromSelected('{{$selectedSimcard->id}}')">X</a></td>
            </tr>
        </tbody>
    </table>
    @else
    <div class="form-group customSelectOption mb-3" >
        <span><i class="fas fa-angle-down"></i></span>
        <label for="">Сим карт</label>
        @if(empty($simcards) || $simcards->count() == 0)<i class="text-danger"> - Нет данных для отображения</i>@endif
        <br>
        <input type="text" class="form-control" wire:model.debounce.500ms="simcard" wire:click="$set('dropmenu',true)">
        @if($dropmenu)
       <div class="card" id="simcardDiv" >
            <ul class="list-group">
                @foreach($simcards as $item)
                <li wire:click="selectedItem('{{$item->id}}','{{$item->ssid}}')" class="list-group-item list-group-item-action">
                    <i class="la la-arrow-right text-secondary me-2 {{$item->agent_id}}"></i>
                    {{$item->ssid ?? ''}}
                </li>
                @endforeach
            </ul>
       </div>
       @endif
    </div>
    @endif
</div>

