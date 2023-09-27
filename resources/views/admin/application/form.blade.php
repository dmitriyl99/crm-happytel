<div class="row">
    <div class="col-md-6">

        <div class="mb-3">
            <label for="">Название тарифа</label>
            <select name="region_group_id" class="form-control" id="region_group_id">
                <option value="">Выбрать</option>
                @foreach($region_groups as $item)
                <option value="{{$item->id ?? ''}}" @if(isset($application) && $application->region_group_id == $item->id) selected @endif>{{$item->name ?? ''}}</option>
                @endforeach
            </select>
        </div>

        @livewire('form.plan-component',[
        'simcardId' => old('simcard_id') ?? $application->simcard_id ?? '',
        'planId' => old('plan_id') ?? $application->plan_id ?? '',
        'region_group_id' => old('region_group_id') ?? $application->region_group_id ?? 0
        ])

        @livewire('form.simcard-livewire-component', [
        'simcardId' => old('simcard_id') ?? $application->simcard_id ?? 0,
        'regionId' => old('region_id') ?? $application->region_id ?? 0
        ])

        @if(!isset($application->id))
        <div class="mb-3">
            <a href="javascript:;" class="btn btn-primary" id="add-simcard">Добавить СИМ карту</a>
        </div>
        @endif
        <hr>
        <hr>

        <div class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    @livewire('form.name-livewire-component',[
                    'customerId' => old('customer_id') ?? $application->customer->id ?? '',
                    'full_name' => old('full_name') ?? '',
                    'ticket' => old('ticket') ?? '',
                    'phone' => old('phone') ?? ''
                    ])
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="">Дата активации</label>
                        <input type="date" class="form-control" name="date_start" value="{{date('Y-m-d',strtotime($application->date_start ?? 'today'))}}">
                    </div>
                    <div class="mb-3">
                        <label for="">Дата окончания </label>
                        <input type="date" class="form-control" name="date_finish" value="{{date('Y-m-d',strtotime($application->date_finish ?? 'tomorrow'))}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">

                @foreach(getPaymentTypes() as $item)
                <div class="col-md-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="payment_type" type="radio" id="{{$item->key ?? ''}}" value="{{$item->key ?? ''}}" @if((old('payment_type')==$item->key) || (isset($application->payment_type) && $application->payment_type == $item->key)) checked @endif >
                        <label class="form-check-label" for="{{$item->key ?? ''}}">{{$item->value ?? ''}}</label>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            @livewire('form.simcard-list')
        </div>
    </div>


</div>


@if(!isset($additional))
<input type="hidden" name="status" value="{{request()->status}}">
@else
<input type="hidden" name="status" value="additional">
@endif

@section('js')
<script>
    customToggleDiv('#countryDiv');
    customToggleDiv('#regionDiv');
    customToggleDiv('#planDiv');
    customToggleDiv('#simcardDiv');
    customToggleDiv('#nameDiv');
    new Selectr('#region_group_id', {
        multiple: false
    });
    $(document).on('change', '#region_group_id', function() {
        Livewire.emit('region_group_id_changed', $(this).val());
    });

    $(document).ready(function() {
        Livewire.on('add-simcard', () => {
            $('#region_group_id  option:first').attr("selected", "selected");
        });
    });

    $(document).on('click', '#add-simcard', function() {
        var region_group_id = $('#region_group_id').val();
        var plan_id = $('input[name="plan_id"]:checked').val();
        var simcard_id = $('input[name="simcard_id"]').val();
        if (!region_group_id) {
            alert('Укажите Название тарифа  ');
        } else if (!plan_id) {
            alert('Укажите план  ');
        } else if (!simcard_id) {
            alert('Укажите симкарту  ');
        } else {
            Livewire.emit('add-simcard', {
                region_group_id: region_group_id,
                plan_id: plan_id,
                simcard_id: simcard_id
            });
        }



    });
</script>
@endsection
