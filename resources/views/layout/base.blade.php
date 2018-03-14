<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="googlebot" content="noindex, nofollow">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link href="{{ asset('css/slate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">

    <title>ImgDjinn - @yield('title')</title>
</head>
<body>

<nav id="navbar_base" class="navbar navbar-expand-lg navbar-dark bg-primary text-center">
    <a class="navbar-brand navbar-dark" href="{{ route('getUpload') }}">Home</a>
</nav>
<div class="container">
    @yield('content')
    @yield('footer')
</div>
@yield('scripts')
</body>
</html>
