@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

<span class="logo-section">
    <a href="/" style="gap: 10px; white-space:normal!important" class="sidebar brand-link d-flex flex-row align-items-center py-4 row-gap-3"
       @if($layoutHelper->isLayoutTopnavEnabled())
           class="navbar-brand {{ config('adminlte.classes_brand') }}"
       @else
           class="brand-link {{ config('adminlte.classes_brand') }}"
        @endif>

        {{-- Small brand logo --}}
        <img src="{{ asset(config('adminlte.logo_img', 'img/logo-willi.png')) }}"
             alt="{{ config('adminlte.logo_img_alt', 'derGreg.com') }}"
             class="{{ config('adminlte.logo_img_class', 'brand-image img-circle elevation-3') }}"
             style="opacity:1">

        {{-- Brand text --}}
        <div>
            <h2 class="brand-text font-weight-normal text-white mb-0 {{ config('adminlte.classes_brand_text') }} logo-header">
            Ticketwilli
        </h2>
        <span class="brand-text lh-sm font-weight-light {{ config('adminlte.classes_brand_text') }} logo-desc">
            Die Online-Pudl für Events
        </span>
        </div>
    </a>
</span>
