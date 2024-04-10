@extends('auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', __('adminlte.verify_message'))

@section('auth_body')

    @if(session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('One time code resent') }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="text-muted my-2 text-center">{{ __('Please enter your one-time password to complete your login.') }}</div>

            <form method="POST" action="{{ route('2fa.verify') }}">
                @csrf

                <div class="form-group">
                    <label for="one_time_password">{{ __('Verification Code') }}</label>
                    <input id="one_time_password" type="text" class="form-control @error('one_time_password') is-invalid @enderror" name="one_time_password" required autofocus>
                    @error('one_time_password')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Verify') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="text-center">
                    <a href="{{ route('2fa.resendCode') }}">{{ __('Resend Code') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
