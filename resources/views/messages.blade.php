<!-- Display Success Messages -->
@if(session()->has('success'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible fade show alert-hide">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> {{ session('success') }}</h5>
            </div>
        </div>
    </div>
@endif

<!-- Display Error Messages -->
@if(session()->has('error'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show alert-hide">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> {{ session('error') }}</h5>
            </div>
        </div>
    </div>
@elseif(request()->has('error'))
    @php
    $error = match (request()->get('error')) {
        'stripe_refresh' => 'Something went wrong. Try one more time please.',
        'stripe_return' => 'You have not finished Stripe onboarding flow.',
        default => 'Something went wrong.'
    }
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show alert-hide">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> {{ $error }}</h5>
            </div>
        </div>
    </div>
@elseif($errors->any())
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show alert-hide">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Operation failed!</h5>
            </div>
        </div>
    </div>
@endif

{{--{{ dump($errors) }}--}}
