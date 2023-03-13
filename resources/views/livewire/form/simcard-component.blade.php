<div>
    <div class="mb-3">
        <div class="input-group mb-1">
            <span class="input-group-text"><input type="checkbox" wire:model="manual"></span>
            <input placeholder="simcard simcard" type="text" class="form-control"  aria-describedby="button-addonMain" name="simcards[]" wire:model.debounce.100ms="simcard">
            <button class="btn btn-success" type="button" id="button-addonMain" wire:click="addSimcard()">+</button>
        </div>
        <div>Считать симкарты: <b>{{count($simcards)}}</b></div>
        @foreach($simcards ?? [] as $key => $item)
        <div class="input-group mb-1">
            <input readonly placeholder="simcard {{$key}}" type="text" class="form-control"  aria-describedby="button-addon{{$key}}" name="simcards[]" wire:model="simcards.{{$key}}">
            <button  class="btn btn-secondary" type="button" id="button-addon{{$key}}" wire:click="removeSimcard('{{$key}}')">-</button>
        </div>
        @endforeach
      
    </div>
</div>
