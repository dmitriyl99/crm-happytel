<div>
    <div class="mb-3">
        <div class="input-group mb-1">
            <span class="input-group-text"><input type="checkbox" wire:model="manual">Manual</span>
{{--            <span class="input-group-text"><input type="checkbox" name="simcards[esim]" wire:model="esim" value="off">Esim</span>--}}
{{--            <div class="col-md-3">--}}
{{--                <select class="form-control" name="simcards[esim]">--}}
{{--                    <option value="off" selected>Обычный</option>--}}
{{--                    <option value="on">Esim</option>--}}
{{--                </select>--}}
{{--            </div>--}}
            <input placeholder="simcard simcard" type="text" class="form-control"  aria-describedby="button-addonMain" name="simcards[ssid]" wire:model.debounce.100ms="simcard">
            <button class="btn btn-success" type="button" id="button-addonMain" wire:click="addSimcard()">+</button>
        </div>
        <div>Считать симкарты: <b>{{count($simcards)}}</b></div>
        @foreach($simcards ?? [] as $key => $item)
        <div class="input-group mb-1">
            <span class="input-group-text">
                <input type='hidden' value='false' name='simcards[esim][{{$key}}]'>
                <input type="checkbox" name="simcards[esim][{{$key}}]" value="true" wire:model="simcards.{{$key}}.esim">Esim
            </span>
            <input readonly placeholder="simcard {{$key}}" type="text" class="form-control"  aria-describedby="button-addon{{$key}}" name="simcards[ssid][]" wire:model="simcards.{{$key}}.ssid">
            <button  class="btn btn-secondary" type="button" id="button-addon{{$key}}" wire:click="removeSimcard('{{$key}}')">-</button>
        </div>
        @endforeach

    </div>
</div>
