<div class="mb-3">
    <label for="">ФИО</label>
    <input class="form-control" type="text" name="full_name" placeholder="ФИО" value="{{old('full_name') ?? $customer->full_name ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Телефон</label>
    <input class="form-control" type="text" name="phone" placeholder="Телефон" value="{{old('phone') ?? $customer->phone ?? ''}}" required>
</div>



<div class="mb-3">
    <label for="">Статус</label>
    <select name="status" class="form-control">
        @foreach (config('custom.status') as $key => $item)
        <option value="{{$key}}" @if((isset($customer->status) && $customer->status == $key) || old('status') == $key) selected @endif >{{$item}}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    @if(isset($customer->passport) && $customer->passport)
    <a href="{{$customer->passport}}" target="_blank">
        <img src="{{asset($customer->passport)}}" alt="passport" style="width: 400px;">
    </a>
    @endif
</div>
<div class="mb-3">
    <label for="">Пасспорт</label>

    <input type="file" name="passport" class="form-control">
</div>
