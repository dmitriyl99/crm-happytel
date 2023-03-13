<div>
    <div class="mb-3">
        <label for="">Регион</label>
        <select name="region_id" class="form-control" wire:model="regionId" id="regionSelectOption">
            <option value="">Выбрать</option>
            @foreach ($regions ?? [] as $item)
            <option value="{{$item->id}}">{{$item->name }}</option>
            @endforeach
        </select>
    </div>
</div>

