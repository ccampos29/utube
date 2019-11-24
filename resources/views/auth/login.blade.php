@extends('layouts.app')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<div class="container div-center">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-background">
                <div class="card-body">
                    <img id="profile-img" class="profile-img-card" src="{{ asset('images/site/logo.png') }}" />
                    <h3 id="profile-name" class="profile-name-card">Login</h3>
                    <br>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Iniciar Sesion') }}
                            </button>
                        </div>

                        <div class="form-group">
                            <a class="nav-link btn btn-success btn-block" href="{{ route('register') }}">Registrarme</a>
                        </div>

                        <div class="clearfix">
                            <label class="float-left checkbox-inline"><input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}</label>
                            @if (Route::has('password.request'))
                                <a class="float-right" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
