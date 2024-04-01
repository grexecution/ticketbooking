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
                @each('partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>

        <div class="sidebar-help">
            <h5 class="sidebar-help-header">Do you need help?</h5>
            <p class="sidebar-help-description">If you need help, please contact us at any time and read my FAQ</p>
            <button class="btn btn-black btn-block bg-black" data-toggle="modal" data-target="#supportModal">Get Help</button>
        </div>
    </div>

</aside>
