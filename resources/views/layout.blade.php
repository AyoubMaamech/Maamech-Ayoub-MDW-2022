<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> @isset($title) {{ $title }} @else @hasSection ('title') @yield('title') @else {{ config('app.name') }} @endif @endif </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png')}}">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ asset('css/normalize.css')}}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css')}}">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('fonts/flaticon.css')}}">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="{{ asset('css/fullcalendar.min.css')}}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('css/animate.min.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('style.css')}}">
    <style> .admin-img > img {display: inline-block; object-fit: cover; height: 40px; width: 40px;} </style>
    @yield('styles')
    <!-- Modernize js -->
    <script src="{{ asset('js/modernizr-3.6.0.min.js')}}"></script>
</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

@yield('content')

    <!-- jquery-->
    <script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('js/plugins.js')}}"></script>
    <!-- Popper js -->
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <!-- Counterup Js -->
    <script src="{{ asset('js/jquery.counterup.min.js')}}"></script>
    <!-- Moment Js -->
    <script src="{{ asset('js/moment.min.js')}}"></script>
    <!-- Waypoints Js -->
    <script src="{{ asset('js/jquery.waypoints.min.js')}}"></script>
    <!-- Scroll Up Js -->
    <script src="{{ asset('js/jquery.scrollUp.min.js')}}"></script>
    <!-- Full Calender Js -->
    <script src="{{ asset('js/fullcalendar.min.js')}}"></script>
    <!-- Chart Js -->
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('js/main.js')}}"></script>
    @yield('scripts')

</body>

</html>