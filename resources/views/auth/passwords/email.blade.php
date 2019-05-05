@extends('layouts.app')

@section('content')
    <div class="pad-top-50 p-4">
        <center><h1 class="fa-3x">{{ __('Reset Password') }}</h1></center>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="row pad-top-50">
                <div class="md-form col-md-8 mx-auto">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary btn-md capitalize">
                        {{ __('Send Reset Link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('right')
    <div class="bg-img bg-tirangles-3 h-100"></div>
@endsection