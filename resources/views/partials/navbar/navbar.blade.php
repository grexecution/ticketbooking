<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

{{--     Navbar left links --}}
    <ul class="navbar-nav">
{{--         Left sidebar toggler link --}}
        @include('partials.navbar.menu-item-left-sidebar-toggler')

{{--         Configured left links --}}
        @each('partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

{{--         Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

{{--     Navbar right links --}}
    <ul class="navbar-nav ml-auto">
{{--         Custom right links --}}
{{--        @yield('content_top_nav_right')--}}

{{--         Configured right links --}}
{{--        @each('partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')--}}

{{--         User menu link --}}
{{--        @if(Auth::user())--}}
{{--            @if(config('adminlte.usermenu_enabled'))--}}
{{--                @include('partials.navbar.menu-item-dropdown-user-menu')--}}
{{--            @else--}}
{{--                @include('partials.navbar.menu-item-logout-link')--}}
{{--            @endif--}}
{{--        @endif--}}

{{--         Right sidebar toggler link --}}
{{--        @if(config('adminlte.right_sidebar'))--}}
{{--            @include('partials.navbar.menu-item-right-sidebar-toggler')--}}
{{--        @endif--}}
    </ul>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center w-100">
            <!-- Left Block -->
            <div class="col-md-6">
{{--                <h3 style="display: inline; margin-right: 1rem;">@yield('title_header')</h3>--}}
                <a href="{{ url()->previous() }}" class="btn btn-default">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <p class="mb-0">@yield('desc_header')</p>
            </div>

            <!-- Right Block -->
{{--            <div class="col-md-6 text-right">--}}
                <div class="d-flex flex-row justify-content-end align-items-center" style="gap: 16px">
                    <div class="user-info">
                        <div class="user-details">
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            <br>
                            <span class="position">{{ auth()->user()->position ?? 'Administrator' }}</span>
                        </div>
                        <img src="{{ asset('img/avatar_demo.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                </div>
{{--            </div>--}}
        </div>
    </div>
</nav>
