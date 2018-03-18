<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="An image upload site focused on privacy and data retention"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('css/slate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">
    @yield('css')
    <title>{{env('APP_NAME')}} - @yield('title')</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand navbar-dark" href="#" data-toggle="modal" data-target="#upload">{{ __('Upload') }}</a>
    <a class="navbar-brand navbar-dark" href="{{ route('home') }}">{{ __('Home') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation" style="">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            @if(Auth::check())
                <li class="nav-item active">
                    <a class="navbar-brand navbar-dark" href="{{ route('getProfile') }}">{{ __('Profile') }}</a>
                </li>
                <li class="nav-item active">
                    <a class="navbar-brand navbar-dark" href="{{ route('getAlbumsUser') }}">{{ __('Albums') }}</a>
                </li>
                <li class="nav-item active">
                    <a class="navbar-brand navbar-dark" href="{{ route('getImagesUser') }}">{{ __('Images') }}</a>
                </li>
                <li class="nav-item active">
                    <a class="navbar-brand navbar-dark" href="{{ route('getLogout') }}">{{ __('Logout') }}</a>
                </li>
            @else
                <li class="nav-item active">
                    <a class="navbar-brand navbar-dark" href="{{ route('getLogin') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item active">
                    <a class="navbar-brand navbar-dark" href="{{ route('getRegister') }}">{{ __('Register') }}</a>
                </li>
            @endif
            <li class="nav-item active">
                <a class="navbar-brand navbar-dark" href="{{ route('faq') }}">FAQ</a>
            </li>
        </ul>
    </div>
</nav>
<div class="splitter"></div>
<div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12">
                    @if(Session::has('album_delete_success'))
                        <div class="alert alert-info text-center">
                            {{Session::get('album_delete_success')}}
                        </div>
                    @endif
                    @if(Session::has('image_delete_success'))
                        <div class="alert alert-info text-center">
                            {{Session::get('image_delete_success')}}
                        </div>
                    @endif

                    @foreach($errors->all() as $message)
                        <div class="alert alert-danger text-center">
                            {{ $message}}
                        </div>
                    @endforeach

                    <form action="{{ route('postUpload') }}" id="__form_submit" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="btn btn-primary btn-lg btn-block">
                                Add image(s)<input type="file" class="form-control-file" id="img"
                                                   aria-describedby="fileHelp"
                                                   name="img[]"
                                                   multiple hidden>
                            </label>
                        </div>
                        <div class="text-center">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label ">
                                    <input class="form-check-input" type="checkbox" name="private">
                                    Private
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="nsfw">
                                    NSFW
                                </label>
                            </div>
                        </div>
                        @if(!Auth::check())
                            <div class="form-check">

                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optionsRadios" id="tokenNone"
                                           value="none"
                                           onclick="hidePasswordInput(); showNoneText();" checked="checked">
                                    Don't create a token or password
                                    <small id="none" class="form-text text-muted">You(or anyone else for that matter)
                                        won't be able
                                        to delete this image/album
                                    </small>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optionsRadios" id="tokenRadio"
                                           value="token"
                                           onclick="hidePasswordInput();">
                                    Auto-generate a delete token
                                </label>
                            </div>

                            <fieldset class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios"
                                               id="passwordRadio"
                                               value="password" onclick="showPasswordInput();">
                                        Allow me to enter a password
                                    </label>
                                </div>

                                <div class="form-group" id="passwordForm">
                                    <input type="password" class="form-control" id="password" name="password"
                                           aria-describedby="passwordHelp">
                                </div>
                            </fieldset>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    @yield('content')
    @yield('footer')
</div>
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tether.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/upload.js') }}"></script>
<script type="text/javascript">
    $('#upload').on('shown.bs.modal', function (e) {
        e.preventDefault();
    });

    $('#img').on('change', function () {
        $('#__form_submit').submit();
    });
</script>
@yield('scripts')
</body>
</html>
