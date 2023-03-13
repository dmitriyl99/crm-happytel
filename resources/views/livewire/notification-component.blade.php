<div>
    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <i class="ti ti-bell"></i>
        @if(count($notifications ?? []))
        <span class="alert-badge"></span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">

        <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
            Уведомления <span class="badge bg-soft-primary badge-pill">@if($notifications) {{$notifications->count()}}  @endif</span>
        </h6>
        <div class="notification-menu" data-simplebar>
            @forelse($notifications as $key => $item)
            <a href="{{route('admin.application.show',$item->application_id ?? 0)}}" class="dropdown-item py-3">
                <small class="float-end text-muted ps-2">{{$item->created_at }}</small>
                <div class="media">
                    <div class="avatar-md bg-soft-primary">
                        <i class="ti ti-chart-arcs"></i>
                    </div>
                    <div class="media-body align-self-center ms-2 text-truncate">
                        <h6 class="my-0 fw-normal text-dark">{{$item->agent->title ?? ''}}</h6>
                        <small class="text-muted mb-0">@lang($item->message ?? '')</small>
                    </div>
                    <!--end media-body-->
                </div>
                <!--end media-->
            </a> 
            @empty
            <a href="#" class="dropdown-item py-3">
                Нет данных для отображения
            </a> 
           
            @endforelse
            
        </div>
        @if(count($notifications ?? []))
        <a href="javascript:void(0);" class="dropdown-item text-center text-primary" wire:click="markAsRead">
            Выбрать все как прочитанное <i class="fi-arrow-right"></i>
        </a>
        @endif
    </div>
</div>
