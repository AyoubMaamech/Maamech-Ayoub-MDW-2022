@extends('layout')

@section('title')
    @lang('Login')
@endsection

@section('content')
    <!-- Login Page Start Here -->
    <div class="login-page-wrap">
        <div class="login-page-content">
            <div class="login-box">
                <div class="item-logo">
                    <img src="{{ asset('img/logo2.png')}}" alt="logo">
                </div>
                

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />



                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
        
                    <div class="form-group">
                        <label for="email">@lang('Email')</label>
                        <input type="email" name ="email" id="email" placeholder="@lang('Enter email')" value="{{old('email')}}" class="form-control">
                        <i class="far fa-envelope"></i>
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('Password')</label>
                        <input type="password" name="password" id="password" placeholder="Enter password" class="form-control">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <label for="remember_me" class="form-check-label">@lang('Remember me')</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="forgot-btn" href="{{ route('password.request') }}">
                                @lang('Forgot your password?')
                            </a>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="login-btn">@lang('Login')</button>
                    </div>
                </form>

            </div>
            <div class="sign-up">@lang('Don\'t have an account ?') <a href="{{ route('register') }}">@lang('Sign Up')</a></div>
        </div>
    </div>
    <!-- Login Page End Here -->
@endsection
