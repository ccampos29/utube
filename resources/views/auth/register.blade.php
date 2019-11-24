@extends('layouts.app')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<div class="container div-center">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card card-background">
                <div class="card-body">
                    <img id="profile-img" class="profile-img-card" src="{{ asset('images/site/logo.png') }}" />
                    <h3 id="profile-name" class="profile-name-card">Registrarme</h3>
                    <br>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col">
                                <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-7">
                                <label for="email"
                                    class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>

                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col">
                                <label for="password-confirm"
                                    class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>


                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">

                            </div>
                        </div>

                        <div class="form-row col-xs-12">
                            <div class="d-block mx-auto">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrarme') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection