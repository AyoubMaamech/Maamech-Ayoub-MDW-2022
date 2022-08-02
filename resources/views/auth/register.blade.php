@extends('layout')

@section('title')
    @lang('Sign Up')
@endsection

@section('content')
    <!-- Login Page Start Here -->
    <div class="login-page-wrap">
        <div class="login-page-content">
            <div class="login-box">
                <div class="item-logo">
                    <img src="{{ asset('img/logo2.png')}}" alt="logo">
                </div>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />



                <form method="POST" action="{{ route('register') }}" class="login-form">
                    @csrf
        
                    <div class="form-group">
                        <label for="name">@lang('Register As')</label>
                        <select name ="profile" id="profile" placeholder="@lang('Select Profile')" value="{{old('name')}}" class="form-control" required>
                            <option value="student" selected>@lang('Student')</option>
                            <option value="parent" >@lang('Parent' )</option>
                            <option value="teacher">@lang('Teacher')</option>
                        </select>
                        <i class="far fa-user"></i>
                    </div>
        
                    <div class="form-group">
                        <label for="name">@lang('Username')</label>
                        <input type="text" name ="name" id="name" placeholder="@lang('Enter usrename')" value="{{old('name')}}" class="form-control" required>
                        <i class="far fa-user"></i>
                    </div>
        
                    <div class="form-group">
                        <label for="email">@lang('Email')</label>
                        <input type="email" name ="email" id="email" placeholder="@lang('Enter email')" value="{{old('email')}}" class="form-control" required>
                        <i class="far fa-envelope"></i>
                    </div>

                    <div class="form-group">
                        <label for="password">@lang('Password')</label>
                        <input type="password" name="password" id="password" placeholder="@lang('Enter password')" class="form-control" required>
                        <i class="fas fa-lock"></i>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">@lang('Confirm password')</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="@lang('Confirm password')" class="form-control" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="login-btn">@lang('Sign Up')</button>
                    </div>
                </form>

            </div>
            <div class="sign-up">@lang('Already have an account ?') <a href="{{ route('login') }}">@lang('Login')</a></div>
        </div>
    </div>
    <!-- Login Page End Here -->
@endsection
