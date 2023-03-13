<input type="hidden" name="user_id" value="{{$agent->user->id ?? ''}}">
<div class="mb-3">
    <label for="">Название тур агентства </label>
    <input class="form-control" type="text" name="title" placeholder="Название тур агентства " value="{{old('title') ?? $agent->title ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Остаток средств</label>
    <input class="form-control" type="text" name="balance" placeholder="Остаток средств" value="{{old('balance') ?? $agent->balance ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Адрес</label>
    <textarea class="form-control" name="address" id="" cols="30" rows="10" placeholder="Адрес" >{{old('address') ?? $agent->address ?? ''}}</textarea>
</div>

<div class="mb-3">
    <label for="">Телефон</label>
    <input class="form-control" type="text" name="phone" placeholder="Телефон " value="{{old('phone') ?? $agent->phone ?? ''}}" required>
</div>


<div class="mb-3">
    <label for="">Статус</label>
    <select name="status" class="form-control">
        @foreach (config('custom.status') as $key => $item)
            <option value="{{$key}}" @if((isset($agent->status) && $agent->status == $key) || old('status') == $key) selected @endif >{{$item}}</option>
        @endforeach
    </select>
</div>


