<div>
    <div class="row mt-4">
        
        @forelse($plans as $item)
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input name="plan_id" class="form-check-input" type="radio" id="flexSwitchCheckDefault{{$item->id}}" value="{{$item->id}}" wire:model="planId"
                        >
                        <label class="form-check-label" for="flexSwitchCheckDefault{{$item->id}}">{{$item->name}} {{$item->expiry_day}} день</label>
                    </div>
                    <br>
                    <div class="mb-3">
                    <label>Цена:</label> {{number_format($item->price_sell)}}
                    </div>
                    <br>
                    <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample{{$item->id}}" aria-expanded="true" aria-controls="collapseExample{{$item->id}}">
                        Показать страны
                    </button>
                    <div class="collapse " id="collapseExample{{$item->id}}">
                        <div class="card mb-0 card-body">
                            @foreach ($item->regions ?? [] as $region)
                            {{$region->name ?? ''}}<br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-md-12 ">
        <div class="mb-2">
        	<b>Тарифы</b>
        </div>
        <span class="text-danger">Нет данных для отображения</span>
        
        </div>
        @endforelse
        <input type="hidden" name="additional" value="{{$additional}}">
    </div>


</div>
