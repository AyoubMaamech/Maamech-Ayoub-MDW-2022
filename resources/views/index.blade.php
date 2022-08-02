@extends('layout')

@section('content')
    <div id="wrapper" class="wrapper bg-ash">
        <!-- Header Menu Area Start Here -->
        <div class="navbar navbar-expand-md header-menu-one bg-light">
            <div class="nav-bar-header-one">
                <div class="header-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="logo">
                    </a>
                </div>
                <div class="toggle-button sidebar-toggle">
                    <button type="button" class="item-link">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="d-md-none mobile-nav-bar">
                <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse" data-target="#mobile-navbar" aria-expanded="false">
                    <i class="far fa-arrow-alt-circle-down"></i>
                </button>
                <button type="button" class="navbar-toggler sidebar-toggle-mobile">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
                <ul class="navbar-nav">
                    <li class="navbar-item header-search-bar">
                        <div class="input-group stylish-input-group">
                            <span class="input-group-addon">
                                <button type="submit">
                                    <span class="flaticon-search" aria-hidden="true"></span>
                                </button>
                            </span>
                            <input type="text" class="form-control" placeholder="@lang('Find Something . . .')">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="navbar-item dropdown header-admin">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="admin-title">
                                <h5 class="item-title">{{ auth()->user()->name }}</h5>
                                <span class="text-capitalize">@lang(auth()->user()->profile)</span>
                            </div>
                            <div class="admin-img">
                            @if(auth()->user()->profile === 'student')
                                <img src="{{ getImage(auth()->user()->etudiant) }}" alt="photo" width="40" height="40">
                            @elseif(auth()->user()->profile === 'parent')
                                <img src="{{ getImage(auth()->user()->parent) }}" alt="photo" width="40" height="40">
                            @elseif(auth()->user()->profile === 'teacher')
                                <img src="{{ getImage(auth()->user()->enseignant) }}" alt="photo" width="40" height="40">
                            @else
                                <img src="{{ asset('img/figure/parents.jpg') }}" alt="photo" width="40" height="40">
                            @endif
                                {{--<img src="{{ getImage($post) }}" alt="photo">--}}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title">{{ auth()->user()->name }}</h6>
                            </div>
                            <div class="item-content">
                                <ul class="settings-list">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" hidden>
                                            @csrf                                
                                        </form>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.previousElementSibling.submit();">
                                            <i class="flaticon-turn-off"></i>
                                            @lang('Log Out')
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                     <li class="navbar-item dropdown header-language">
                        <a class="navbar-nav-link dropdown-toggle text-uppercase" href="#" role="button" 
                        data-toggle="dropdown" aria-expanded="false"><i class="fas fa-globe-americas"></i>{{substr(App::currentLocale(), 0, 2)}}</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{route('home', ['lang' => 'en'])}}">English</a>
                            <a class="dropdown-item" href="{{route('home', ['lang' => 'fr'])}}">Français</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Header Menu Area End Here -->
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">

            <x-front.side-bar />

            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                @yield('breadcubs')
                <!-- Breadcubs Area End Here -->
                @yield('dashboard-content')
                <!-- Footer Area Start Here -->
                <footer class="footer-wrap-layout1">
                    <div class="copyright">© Copyrights 2022 <a href="#">Ayoub</a></div>
                </footer>
                <!-- Footer Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
@endsection