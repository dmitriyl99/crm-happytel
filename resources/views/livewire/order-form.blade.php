<div>
    @for($i = 1; $i <= $countSimcard; $i++)
        <h5>{{$i}}</h5>
        @livewire('form.region-input-component',[
            'regionId' => old('region_id') ?? $application->region_id ?? 0
            ], key(time().$i))
        
        @livewire('form.simcard-livewire-component', [
            'simcardId' => old('simcard_id') ?? $application->simcard_id ?? 0, 
            'regionId' => old('region_id') ?? $application->region_id ?? 0
            ], key(time().$i))
        
        @livewire('form.plan-component',[
            'simcardId' => old('simcard_id') ?? $application->simcard_id ?? '',
            'planId' => old('plan_id') ?? $application->plan_id ?? ''
            ], key(time().$i))
        <hr>
    @endfor
    <br>
    <a href="javascript:;" class="btn btn-primary" wire:click="increamentSimcard">+</a><br>
</div>
