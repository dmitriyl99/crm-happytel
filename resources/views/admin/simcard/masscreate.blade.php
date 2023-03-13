@extends('layouts.admin')
@section('title','Добавить Сим карты')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Добавить Сим карты</div>
            <div class="card-body">
                <form action="{{route('admin.simcard.store.mass')}}" method="post" id="simcard-form">
                    @csrf
                	<div class="mb-3">
                        <label>Агент</label>
                        <select class="form-control" name="agent_id">
                            <option value="" disabled selected>Выбирать</option>
                            @forelse($agents as $key => $item)
                            <option value="{{$item->id}}">{{$item->title ?? ''}}</option>
                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                	
                    <?php /* <div class="mb-3">
                        <label>Страны</label>
                        <select id="countryMultiSelect" name="regions[]">
                            @forelse($regions as $key => $item)
                            <option value="{{$item->id}}">{{$item->name ?? ''}}</option>
                            @empty
                                
                            @endforelse
                        </select>

                    </div> */?>
                    <div class="mb-3">
                        <label>Регион группа</label>
                        <select id="countryMultiSelect" name="region_groups[]" required>
                            @forelse($region_groups as $key => $item)
                            <option value="{{$item->id}}">{{$item->name ?? ''}}</option>
                            @empty
                                
                            @endforelse
                        </select>

                    </div>
                    @livewire('form.simcard-component',['simcards' => old('simcards') ?? []])
                    <div class="mb-3">
                        <button class="btn btn-success"  onclick="document.getElementById('simcard-form').submit()">Сохранить</button>
                        <a class="btn" href="{{route('admin.simcard.index')}}">Обратно к списку</a>
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
