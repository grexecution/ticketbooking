<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

{{--     Sidebar brand logo--}}
    @if(config('adminlte.logo_img_xl'))
        @include('partials.common.brand-logo-xl')
    @else
        @include('partials.common.brand-logo-xs')
    @endif

{{--     Sidebar menu--}}
    <div class="sidebar">
        <a href="/account">
            <div class="user-panel mt-3 pb-4 pt-4 mb-3 d-flex flex-column">
                <div class="image">
                    <img src="{{ asset('/img/thegreg_emoji_dev.png') }}" class="elevation-2 rounded" alt="User Image">
                </div>
                <div class="info pt-3">
                    <h3 class="text-white mb-0">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</h3>
                    <a href="#" class="d-block">{{ auth()->user()->email }}</a>
                </div>
            </div>
        </a>

        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
{{--                 Configured sidebar links--}}
{{--                @each('partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')--}}

                <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu">
                    @can('dashboard_access')
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->route()->getName(), 'dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <p>Dashboard</p>
                            </a>
                        </li>
                    @endcan
                    @can('tenant_access')
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->route()->getName(), 'tenants') ? 'active' : '' }}" href="{{ route('tenants.index') }}">
                                <p>Tenants</p>
                            </a>
                        </li>
                    @endcan
                    @can('event_access')
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link {{ str_contains(request()->route()->getName(), 'events') ? 'active' : '' }}">
                                <p>
                                    Events
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('events.index') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'events') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Events</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('venues.index') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'venues') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Venues</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('subscriptions.index') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'subscriptions') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Subscriptions</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('events.index') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'discounts') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Discounts</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('events.index') }}" class="nav-link {{ str_contains(request()->route()->getName(), 'vouchers') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Vouchers</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('finance_access')
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->route()->getName(), 'finance') ? 'active' : '' }}" href="{{ route('finance') }}">
                                <p>Finance</p>
                            </a>
                        </li>
                    @endcan
                    @can('setting_access')
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->route()->getName(), 'settings') ? 'active' : '' }}" href="{{ route('settings') }}">
                                <p>Settings</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </ul>
        </nav>

        <div class="sidebar-help">
            <h5 class="sidebar-help-header">Do you need help?</h5>
            <p class="sidebar-help-description">If you need help, please contact us at any time and read my FAQ</p>
            <button class="btn btn-black btn-block bg-black" data-toggle="modal" data-target="#supportModal">Get Help</button>
        </div>
    </div>

</aside>
