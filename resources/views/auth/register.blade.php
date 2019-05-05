@extends('layouts.app')

@section('content')
    <div class="pad-top-50 p-4">
        <center><h1 class="fa-3x">Register</h1></center>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row">
                <div class="md-form col-md-8 mx-auto">
                    <label>{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="md-form col-md-8 mx-auto">
                    <label>{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">

                <div class="md-form col-md-8 mx-auto">
                    <label>{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">

                <div class="md-form col-md-8 mx-auto">
                    <label>{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="row">
                <input type="hidden" name="permission" id="perm" value="student" required />
                <div data-acc="student" class="accTypeSel stu-sel col-md-5 mx-auto p-2 grey darken-4 white-text waves-effect waves-light">
                    <span class="fa fa-check-circle green-ic"></span>
                    Student Account
                </div>
                <div data-acc="instructor" class="accTypeSel inst-sel col-md-5 mx-auto p-2 waves-effect waves-light">
                    <span class="fa fa-circle-o grey-ic"></span>
                    Instructor Account
                </div>
            </div>
            <div class="row mb-0">
                <div class="md-form col-md-8 mx-auto center-align">
                    <button type="submit" class="btn btn-primary btn-md capitalize">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('right')
    <div class="bg-img bg-tirangles-4 h-100"></div>
@endsection
