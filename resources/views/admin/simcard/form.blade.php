

<div class="mb-3">
    <label>Агент</label>
    <select class="form-control" name="agent_id">
        <option value="" disabled selected>Выбирать</option>
        @forelse($agents as $key => $item)
        <option value="{{$item->id}}" @if($simcard->agent_id == $item->id) selected @endif >{{$item->title ?? ''}}</option>
        @empty
            
        @endforelse
    </select>
</div>

 <div class="mb-3">
    <label>Регион группа</label>
    <select id="countryMultiSelect" name="region_groups[]" multiple  required>
    @php $region_group_id = $simcard->region_groups->pluck('id')->toArray() @endphp
        @forelse($region_groups as $key => $item)
        <option value="{{$item->id}}" @if(in_array($item->id, $region_group_id)) selected @endif>{{$item->name ?? ''}}</option>
        @empty
            
        @endforelse
    </select>

</div>

<div class="mb-3">
    <label for="">ICCID</label>
    <input class="form-control" type="text" name="ssid" placeholder="SSID" value="{{old('ssid') ?? $simcard->ssid ?? ''}}" required>
</div>



{{--<div class="mb-3">
    <label for="">Статус</label>
    <select name="status" class="form-control">
        @foreach (config('custom.status') as $key => $item)
            <option value="{{$key}}" @if((isset($plan) && $plan->status == $key) || old('status') == $key) @endif >{{$item}}</option>
        @endforeach
    </select>
</div>
--}}

@section('js')
<script>
    customToggleDiv('#regionDiv');
    customToggleDiv('#planDiv');
    new Selectr('#countryMultiSelect', {
        multiple: true
    });
    
    $(":input").keypress(function(event){
        if (event.which == '10' || event.which == '13') {
            event.preventDefault();
    	}
	});

</script>
@endsection


