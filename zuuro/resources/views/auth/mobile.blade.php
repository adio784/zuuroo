@extends('app.user.layout.user-layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mt-4">
            <div class="card">
                <div class="card-header">{{ __('Verify Mobile') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ ('mobile') }}">
                        @csrf

                        <div class="row mb-3 mt-4">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Mobile') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="+{{ Auth::user()->mobile }}" required autocomplete="phone_number" readonly autofocus>

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small>To change this number, goto profile </small>
                            </div>
                            
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify') }}
                                {{-- </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
