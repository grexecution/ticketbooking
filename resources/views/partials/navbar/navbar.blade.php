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
                <h3 style="display: inline; margin-right: 1rem;">@yield('title_header')</h3>
                @if(request()->route()->getName() === 'website')
                    @if(auth()->user()->site->is_active)
                        <button type="button" class="btn btn-success">
                            <span class="fas fa-check"></span> Online
                        </button>
                    @elseif(auth()->user()->site->is_suspended)
                        <button type="button" class="btn btn-primary bg-white border border-secondary shadow-sm" onclick="window.location.href='{{ route('website.resume') }}'">
                            Re-activate <i class="fas fa-arrow-alt-circle-up"></i>
                        </button>
                    @endif
                @endif
                <p class="mb-0">@yield('desc_header')</p>
            </div>

            <!-- Right Block -->
{{--            <div class="col-md-6 text-right">--}}
{{--                <div class="d-flex flex-row justify-content-end align-items-center" style="gap: 16px">--}}
{{--                    <p class="mb-0">Ready to take your website live?</p>--}}
{{--                    <button class="btn btn-primary bg-white border border-secondary shadow-sm " data-toggle="modal" data-target="#requestAccessModal">--}}
{{--                        Go live!--}}
{{--                        <i class="fas fa-arrow-right ml-2"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</nav>
