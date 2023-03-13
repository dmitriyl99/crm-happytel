<div>
@if(session('simcards'))
<table class="table table-bordered">
	<thead>
		<tr>
			<td>Регион группа</td>
			<td>План</td>
			<td>ICCID</td>
			<td>#</td>
		</tr>
	</thead>
	<tbody>

	@foreach((session('simcards') ?? []) as $key => $item)
		<input type="hidden" name="region_groups[{{$key}}]" value="{{$item['region']->id ?? ''}}">
		<input type="hidden" name="plans[{{$key}}]" value="{{$item['plan']->id ?? ''}}">
		<input type="hidden" name="simcards[{{$key}}]" value="{{$item['simcard']->id ?? ''}}">
		<tr>
			<td>{{$item['region']->name ?? ''}}</td>
			<td>
			{{number_format($item['plan']->price_sell  ?? 0)}}<br>
			{{$item['plan']->name ?? ''}}
			
			</td>
			<td>{{$item['simcard']->ssid ?? ''}}</td>
			<td><a class="btn btn-danger" wire:click="removeSimcard('{{$key}}')">X</a></td>
		</tr>
	@endforeach
	</tbody>
</table>

@endif
</div>