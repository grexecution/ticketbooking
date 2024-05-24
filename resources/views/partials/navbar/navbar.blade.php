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
            @if(session()->get('loggedAsSuperAdmin'))
                <div class="">
                    You are now in Admin "{{ auth()->user()->name }}" Mode -
                    <br>
                    <span id="goBackToSuperAdminLink" style="cursor: pointer; text-decoration: underline;">click to go back to Superadmin</span>
                    <form name="superAdminLoginForm" id="superAdminLoginForm" method="post" action="{{ route('tenants.superAdminLogin') }}" class="d-inline-block">
                        @csrf
                        <button style="display: none;" type="submit" class="btn btn-dark ml-2">Super Admin Login</button>
                    </form>
                </div
            @endif
            <!-- Right Block -->
{{--            <div class="col-md-6 text-right">--}}
                <a class="" href="{{ route('settings') }}">
                    <div class="d-flex flex-row justify-content-end align-items-center" style="gap: 16px">
                        <div class="user-info d-flex">
                            <div class="user-details">
                                <span class="d-none d-md-inline text-dark">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
                                <br>
                                <span class="position text-bold text-dark">{{ auth()->user()->position ?? 'Administrator' }}</span>
                            </div>
                            @if(auth()->user()?->avatar_url)
                                <img src="{{ auth()->user()->avatar_url }}" class="elevation-2 rounded" alt="User Image">
                            @else
                                <img src="{{ asset('/img/thegreg_emoji_dev.png') }}" width="52px" class="img-circle elevation-2 ml-2" alt="User Image">
                            @endif
                        </div>
                    </div>
                </a>
{{--            </div>--}}
        </div>
    </div>
</nav>
