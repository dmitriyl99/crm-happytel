@extends('layouts.admin') @section('title','Изменить Пользователь')

@section('content')
<!-- Page-Title -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">Добавить доп.план</div>
			<div class="card-body">
				<form
					action="{{route('admin.application.additional.store', $application->id)}}"
					method="post">
					@csrf @php $additional = true; @endphp @method('PUT')
					<input type="hidden" value="{{$application->simcard_id ?? ''}}">
					<div class="row">
						<div class="col-md-4">
							<div class="mb-2">
								<b>SSID</b>
							</div>
							{{$application->simcard->ssid ?? ''}}
						</div>
						<div class="col-md-4">
							<div class="mb-2">
								<b>Название тарифа</b>
							</div>
							{{$application->region_group->name ?? ''}}
						</div>
						<div class="col-md-4">
							<div class="mb-2">
								<b>Тариф</b>
							</div>
							{{$application->plan->name ?? ''}}
						</div>
						<div class="col-md-12 mb-3"></div>
						<div class="col-md-4">
							<div class="mb-2">
								<b>Клиент</b>
							</div>
							{{$application->customer->full_name ?? ''}}<br>
							{{$application->customer->phone ?? ''}}<br>

						</div>
						<div class="col-md-4">
							<div class="mb-2">
								<b>Тип платеж</b>
							</div>
							{{customPaymentType($application->payment_type ?? '')}}<br>

						</div>
						<div class="col-md-4">
							<div class="mb-2">
								<b>Страны</b>
							</div>
							<button class="btn btn-secondary" type="button"
								data-bs-toggle="collapse" data-bs-target="#collapseExample"
								aria-expanded="true" aria-controls="collapseExample">Показать
								страны</button>
							<div class="collapse " id="collapseExample">
								<div class="card mb-0 card-body">
									@foreach ($application->plan->regions ?? [] as $region)
									{{$region->name ?? ''}}<br> @endforeach
								</div>
							</div>

						</div>
						<div class="col-md-12 mb-3">
							<hr>
						</div>
	
						<div class="col-md-12">
							<label for="">Название тарифа</label> <select
								name="region_group_id" class="form-control" id="region_group_id">
								<option value="">Выбрать</option> 
								@foreach($region_groups as $item)
								<option value="{{$item->id ?? ''}}">{{$item->name ?? ''}}</option>
								@endforeach
							</select>
						</div>
						
						<div class="col-md-12">
						
                        @livewire('form.plan-component',[
                            'simcardId' => old('simcard_id') ?? '',
                            'planId' => old('plan_id') ?? '',
                            'additional' => true,
                        ])
                        </div>
					</div>
					<div class="mb-3 mt-4">
						<button class="btn btn-success" type="submit">Отправить</button>
						<a class="btn"
							href="{{route('admin.application.index',$application->status ?? 'new')}}">Обратно
							к списку</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--end col-->
</div>
<!-- end page title end breadcrumb -->
@endsection


@section('js')
<script>
    customToggleDiv('#countryDiv');
    customToggleDiv('#regionDiv');
    customToggleDiv('#planDiv');
    customToggleDiv('#simcardDiv');
    customToggleDiv('#nameDiv');
    new Selectr('#region_group_id',{
        multiple: false
    });
    $(document).on('change','#region_group_id', function(){
    	 Livewire.emit('region_group_id_changed',$(this).val());
    });
    
    $(document).ready(function(){
    	Livewire.on('add-simcard', () => {
    		$('#region_group_id  option:first').attr("selected", "selected");
		});
    });
    
    $(document).on('click','#add-simcard',function(){
    	var region_group_id = $('#region_group_id').val();
    	var plan_id = $('input[name="plan_id"]:checked').val();
    	var simcard_id = $('input[name="simcard_id"]').val();
    	if(!region_group_id){
    		alert('Укажите Название тарифа  ');
    	}else if(!plan_id){
    		alert('Укажите план  ');
    	}
    	else if(!simcard_id){
    		alert('Укажите симкарта  ');
    	}else{
    		Livewire.emit('add-simcard',{region_group_id: region_group_id,plan_id: plan_id,simcard_id:simcard_id });
    	}
    });

</script>
@endsection
