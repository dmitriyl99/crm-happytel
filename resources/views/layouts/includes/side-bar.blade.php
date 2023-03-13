 <!-- leftbar-menu -->
 <div class="left-sidebar">
     <!-- LOGO -->
     <div class="brand">
         <a href="index.html" class="logo">
             {{-- <span>
                 <img src="{{ asset('assets/images/favicon.ico')}}" alt="logo-small" class="logo-sm">
             </span> --}}
             <span>
                 <img src="{{ asset('assets/images/logo.svg')}}" alt="logo-large" class="logo-lg logo-light" style="height: 40px;">
                 <img src="{{ asset('assets/images/logo-dark.png')}}" alt="logo-large" class="logo-lg logo-dark">
             </span>
         </a>
     </div>
     <div class="sidebar-user-pro media border-end">
         <div class="position-relative mx-auto">
             <img src="https://www.happytel.uz/img/how-use/how-use__card_2.svg" alt="user" class="rounded-circle thumb-md">
             <span class="online-icon position-absolute end-0"><i class="mdi mdi-record text-success"></i></span>
         </div>
         <div class="media-body ms-2 user-detail align-self-center">
             <h5 class="font-14 m-0 fw-bold">{{auth()->user()->name}}</h5>
             <p class="opacity-50 mb-0">{{auth()->user()->email}}</p>
         </div>
     </div>
     <!-- Tab panes -->

     <!--end logo-->
     <div class="menu-content h-100" data-simplebar>
         <div class="menu-body navbar-vertical">
             <div class="collapse navbar-collapse tab-content" id="sidebarCollapse">

                 <!-- Navigation -->
                 <ul class="navbar-nav tab-pane active" id="Main" role="tabpanel">

                     <li class="menu-label mt-0 text-primary font-12 fw-semibold">{{auth()->user()->agent->title ?? ''}}<br>
                         <span class="font-10 text-secondary fw-normal">
                             <h2 class="text-white">{{number_format(auth()->user()->agent->balance ?? '')}}</h2>
                         </span>
                     </li>
                     @if(auth()->user()->isSuperAdmin() || auth()->user()->isAgent() || auth()->user()->isAdmin())
                     @if(auth()->user()->isSuperAdmin())
                     @if(auth()->user()->isAgenthappy())
                     <li class="nav-item">
                         <a class="nav-link" href="#product" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAnalytics">
                             <i class="ti ti-stack menu-icon"></i>
                             <span>Гаджеты</span>
                         </a>
                         <div class="collapse " id="product">
                             <ul class="nav flex-column">
                                 <li class="nav-item {{ (request()->is('/admin/product/listproduct*')) ? 'menuitem-active' : '' }}">
                                     <a class="nav-link" href="{{route('admin.listproduct.index')}}">Список Товаров</a>
                                 </li>
                                 <li class="nav-item {{ (request()->is('/admin/product/newp*')) ? 'menuitem-active' : '' }}">
                                     <a class="nav-link" href="{{route('admin.newp.create')}}">Создать Новые Заказы</a>
                                 </li>
                                 <li class="nav-item {{ (request()->is('/admin/newp/newp*')) ? 'menuitem-active' : '' }}">
                                     <a class="nav-link" href="{{route('admin.newp.index')}}">Проданные товары
                                     </a>
                                 </li>
                                 <!--end nav-item-->
                             </ul>
                             <!--end nav-->
                         </div>
                         <!--end sidebarAnalytics-->
                     </li>
                     @endif
                     <li class="nav-item {{ (request()->is('/admin/application/agent*')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.agent.index')}}"><i class="fas fa-building menu-icon"></i><span>Турагенты</span></a>
                     </li>

                     <li class="nav-item {{ (request()->is('/admin/application/customer*')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.customer.index')}}"><i class="fas fa-user-friends menu-icon"></i><span>Клиенты</span></a>
                     </li>

                     <li class="nav-item">
                         <a class="nav-link" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAnalytics">
                             <i class="ti ti-stack menu-icon"></i>
                             <span>Справочники </span>
                         </a>
                         <div class="collapse " id="sidebarAnalytics">
                             <ul class="nav flex-column">
                                 <li class="nav-item {{ (request()->is('/admin/application/region_group*')) ? 'menuitem-active' : '' }}">
                                     <a class="nav-link" href="{{route('admin.region_group.index')}}">Регион группы</a>
                                 </li>
                                 <li class="nav-item {{ (request()->is('/admin/application/region*')) ? 'menuitem-active' : '' }}">
                                     <a class="nav-link" href="{{route('admin.region.index')}}">Региони</a>
                                 </li>
                                 <!--end nav-item-->
                                 <li class="nav-item {{ (request()->is('/admin/application/plan*') || request()->is('/admin/application/plan/*')) ? 'menuitem-active' : '' }}">
                                     <a href="{{route('admin.plan.index')}}" class="nav-link ">Тарифы</a>
                                 </li>
                                 <li class="nav-item {{ (request()->is('/admin/application/additionally*')) ? 'menuitem-active' : '' }}">
                                     <a href="{{route('admin.additionally.plan','additional')}}" class="nav-link ">Дополнительный план</a>
                                 </li>
                                 <!--end nav-item-->
                                 <li class="nav-item {{ (request()->is('/admin/application/simcard*')) ? 'menuitem-active' : '' }}">
                                     <a href="{{route('admin.simcard.index')}}" class="nav-link ">Сим карты</a>
                                 </li>
                                 <!--end nav-item-->

                                 <li class="nav-item {{ (request()->is('/admin/application/provider*')) ? 'menuitem-active' : '' }}">
                                     <a href="{{route('admin.provider.index')}}" class="nav-link ">Поставщик</a>
                                 </li>
                                 <!--end nav-item-->

                             </ul>
                             <!--end nav-->
                         </div>
                         <!--end sidebarAnalytics-->
                     </li>

                     <li class="nav-item">
                         <a class="nav-link" href="#sidebarUserManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrypto">
                             <i class="fas fa-cogs menu-icon"></i>
                             <span>Управление </span>
                         </a>
                         <div class="collapse " id="sidebarUserManagement">
                             <ul class="nav flex-column">
                                 <li class="nav-item {{ (request()->is('/admin/application/user*')) ? 'menuitem-active' : '' }}">
                                     <a class="nav-link" href="{{route('admin.user.index')}}">Пользователи</a>
                                 </li>
                                 <li class="nav-item {{ (request()->is('/admin/settings/status*')) ? 'menuitem-active' : '' }}">
                                     <a class="nav-link" href="{{route('admin.edit.status')}}">Статусы</a>
                                 </li>
                                 <li class="nav-item {{ (request()->is('/admin/settings/payment-type*')) ? 'menuitem-active' : '' }}">
                                     <a class="nav-link" href="{{route('admin.edit.payment.types')}}">Тип платежи</a>
                                 </li>
                                 <li class="nav-item {{ (request()->is('/admin/settings/*')) ? 'menuitem-active' : '' }}">
                                     <a class="nav-link" href="{{route('admin.edit.global.settings')}}">Настройки</a>
                                 </li>
                             </ul>
                         </div>
                     </li>
                     @endif
                     @if(auth()->user()->isSuperAdmin() || auth()->user()->isAgent())
                     <li class="nav-item {{ (request()->is('/admin/application/report*')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.report','agent')}}"><i class="fas fa-chart-bar menu-icon"></i><span>Отчеты</span></a>
                     </li>
                     @endif
                     <li class="nav-item {{ (request()->is('/admin/application/list/new')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.application.create','new')}}"><i class="far fa-plus-square menu-icon"></i><span>Создать новый заказ </span></a>
                     </li>
                     @endif
                     @if(auth()->user()->isUser())
                     <li class="nav-item {{ (request()->is('/admin/application/report*')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.report','agent')}}"><i class="fas fa-chart-bar menu-icon"></i><span>Reports</span></a>
                     </li>
                     <li class="nav-item {{ (request()->is('/admin/application/list/new')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.application.index','new')}}"><i class="fas fa-bars menu-icon"></i><span>New orders</span>
                         </a>
                     </li>
                     <li class="nav-item {{ (request()->is('/admin/application/list/new')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.application.index','cancel')}}"><i class="fas fa-bars menu-icon"></i><span>Canceled orders</span>
                         </a>
                     </li>
                     <li class="nav-item {{ (request()->is('/admin/application/list/accepted')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.application.index','accepted')}}"><i class="fas fa-check-circle menu-icon"></i><span>Active orders</span></a>
                     </li>
                     @endif
                     @if(auth()->user()->isSuperAdmin() || auth()->user()->isAgent() || auth()->user()->isAdmin())
                     <li class="nav-item {{ (request()->is('/admin/application/list/new')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.application.index','new')}}"><i class="fas fa-bars menu-icon"></i><span>Новые заказы<span class="badge badge-outline-success ml-3" style="margin-left: 20px;">{{$order['new']}}</span></span>
                         </a>
                     </li>
                     <li class="nav-item {{ (request()->is('/admin/application/list/new')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.application.index','cancel')}}"><i class="fas fa-bars menu-icon"></i><span>Отмененные заказы<span class="badge badge-outline-success ml-3" style="margin-left: 20px;">{{$order['cancel']}}</span></span>
                         </a>
                     </li>
                     <li class="nav-item {{ (request()->is('/admin/application/list/accepted')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.application.index','accepted')}}"><i class="fas fa-check-circle menu-icon"></i><span>Активные заказы </span> <span class="badge badge-outline-success ml-3" style="margin-left: 20px;">{{$order['accepted']}}</span></a>
                     </li>
                     @endif
                     @if(auth()->user()->isSuperAdmin() || auth()->user()->isAgent() || auth()->user()->isAdmin())
                     <li class="nav-item {{ (request()->is('/admin/application/list/additional')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.application.index','additional')}}"><i class="fas fa-list-ul menu-icon"></i><span>Продление сим карты</span></a>
                     </li>
                     <li class="nav-item {{ (request()->is('/admin/application/list/all')) ? 'menuitem-active' : '' }}">
                         <a class="nav-link" href="{{route('admin.application.index','all')}}"><i class="fas fa-archive menu-icon"></i><span>Все заказы<span class="badge badge-outline-success ml-3" style="margin-left: 20px;">{{$order['all']}}</span></span></a>
                     </li>

                     <li class="nav-item ">
                         <a class="nav-link" href="{{route('admin.customer.index')}}"><i class="fas fa-users menu-icon"></i><span>Список клиентов</span></a>
                     </li>
                     @endif
                 </ul>
                 <ul class="navbar-nav tab-pane" id="Extra" role="tabpanel">
                     <li>
                         <div class="update-msg text-center position-relative">
                             <button type="button" class="btn-close position-absolute end-0 me-2" aria-label="Close"></button>
                             <img src="{{ asset('assets/images/speaker-light.png')}}" alt="" class="" height="110">
                             <h5 class="mt-0">CRM Happytel</h5>
                             <p class="mb-3">We Design and Develop Clean and High Quality Web Applications</p>
                             <a href="javascript: void(0);" class="btn btn-outline-warning btn-sm">Upgrade your plan</a>
                         </div>
                     </li>
                 </ul>
                 <!--end navbar-nav--->
             </div>
             <!--end sidebarCollapse-->
         </div>
     </div>
 </div>
 <!-- end left-sidenav-->
 <!-- end leftbar-menu-->