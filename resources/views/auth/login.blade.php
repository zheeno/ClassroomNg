@extends('layouts.app')

@section('content')
    <div class="pad-top-50 p-4">
        <center><h1 class="fa-3x">Login</h1></center>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="row">
                <div class="md-form col-md-8 mx-auto">
                    <label class="active">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="md-form col-md-8 mx-auto">
                    <label class="active">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 center-align">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="note" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="col-12 center-align">
                    <button type="submit" class="btn btn-primary btn-md capitalize">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection

@section('right')
    <div class="bg-img bg-tirangles-1 h-100"></div>
@endsection
