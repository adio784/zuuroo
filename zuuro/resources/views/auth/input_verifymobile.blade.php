@extends('app.user.layout.user-layout')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ 'Input OTP sent to your number: '. session('phone_number') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ ('verify_otp') }}">
                        @csrf

                        <!-- Result  -->
                        <div id="error_result">
                            @if(Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show text-dark" role="alert">
                                    <strong>Success!</strong> {{ Session::get('success') }}
                                </div>
                            @endif
                            @if(Session::get('fail'))
                            <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                                <strong>Oh Oops!</strong> {{ Session::get('fail') }}
                            </div>
                            @endif
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-10">
                                <label for="verification_code" class="col-form-label text-md-end">{{ __('OTP') }}</label>
                                <input type="hidden" name="phone_number" value="+{{ Auth::user()->mobile }}">
                                {{-- <input type="hidden" name="otp_input" value="{{ session('otp') }}"> --}}
                                <input id="verification_code" type="tel" class="form-control @error('verification_code') is-invalid @enderror" name="verification_code" value="{{ old('verification_code') }}" required autocomplete="verification_code" autofocus>
                                <small>OTP expires after 10 mins ...</small>
                                <SMall>Didn't receive a code? Go back and try again.</SMall>

                                @error('verification_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>

                        </div>
                    </form>
                    <div class="col-md-6">
                        <form method="POST" action="{{ ('mobile') }}">
                            @csrf
                            <input type="hidden" name="phone_number" value="+{{ Auth::user()->mobile }}">
                            <button type="submit" class="btn btn-info">
                                {{ __('Resend OTP') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
