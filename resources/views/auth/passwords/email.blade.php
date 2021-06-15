@extends('layouts.app')

@section('content')
<div class="auth-fluid-form-box">
    <div class="align-items-center d-flex h-100">

                <div class="card-body">
                    <h4 class="mt-0">{{ __('auth.reset_password') }}</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email">{{ __('auth.email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group mb-0 text-center">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('auth.send_link_password') }}
                                </button>
                        </div>
                    </form>
                </div>
    </div>
</div>
@endsection
