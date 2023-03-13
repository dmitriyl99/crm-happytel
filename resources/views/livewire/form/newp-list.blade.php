<div>
@if(session('newp'))
<table class="table table-bordered">
	<thead>
		<tr>
			<td>Название</td>
			<td>Количество</td>
			<td>#</td>
		</tr>
	</thead>
	<tbody>

	@foreach((session('newp') ?? []) as $key => $item)
		<input type="hidden" name="product_id[{{$key}}]" value="{{$item['product']->id ?? ''}}">
		<input type="hidden" name="count[{{$key}}]" value="{{$item['count'] ?? ''}}">
		<tr>
			<td>{{$item['products'] ?? ''}}</td>
			<td>{{$item['count'] ?? ''}}</td>
			<td><a class="btn btn-danger" wire:click="removeProduct('{{$key}}')">X</a></td>
		</tr>
	@endforeach
	</tbody>
</table>
@endif
</div>