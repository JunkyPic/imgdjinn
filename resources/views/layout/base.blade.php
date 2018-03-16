<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="An image upload site focused on privacy and data retention" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('css/slate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">

    <title>{{env('APP_NAME')}} - @yield('title')</title>
    <?php header('Cache-Control: max-age=9999999'); ?>
</head>
<body>
<nav id="navbar_base" class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand navbar-dark" href="{{ route('getUpload') }}">Home</a>
    @if(Auth::check())
        <a class="navbar-brand navbar-dark" href="{{ route('getProfile') }}">{{ __('Profile') }}</a>
        <a class="navbar-brand navbar-dark" href="{{ route('getAlbumsUser') }}">{{ __('Albums') }}</a>
        <a class="navbar-brand navbar-dark" href="{{ route('getImagesUser') }}">{{ __('Images') }}</a>
        <a class="navbar-brand navbar-dark" href="{{ route('getLogout') }}">{{ __('Logout') }}</a>
    @else
        <a class="navbar-brand navbar-dark" href="{{ route('getLogin') }}">{{ __('Login') }}</a>
        <a class="navbar-brand navbar-dark" href="{{ route('getRegister') }}">{{ __('Register') }}</a>
    @endif
    <a class="navbar-brand navbar-dark" href="{{ route('faq') }}">FAQ</a>
</nav>
<div class="container">
    @yield('content')
    @yield('footer')
</div>
@yield('scripts')
</body>
</html>
