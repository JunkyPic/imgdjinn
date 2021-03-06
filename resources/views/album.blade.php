@extends('layout.base')

@section('title')
    Album
@endsection

@section('content')

    @if(Session::has('error'))
        <div class="alert alert-danger col-lg-8 text-center offset-lg-2">
            {{Session::get('error')}}
        </div>
    @endif

    @if($display_token)
        <div class="alert alert-info col-lg-8 text-center offset-lg-2">
            This message will appear ONLY once.
            <br>
            This is your token for this album, it can be used to delete it, even if not logged in.
            For images in this album, this token applies.
            <br>
            <br>
            <strong>{{ $album->token }}</strong>
            <br>
            <button type="button" id="btn" data-clipboard-text="{{ $album->token }}" class="btn btn-primary btn-lg btn-block">Copy token</button>
        </div>
    @endif

    @foreach($album->images()->get() as $item)
        @if(strstr($item->path, '.webm'))
            <div class="col-lg-12 text-center" style="padding: 20px 0 20px 0;">
                <a target="_blank" rel="noopener" href="{{url('/img/' . $item->path)}}">
                    <video width="100%" controls autoplay loop>
                        <source src="{{  url('/img/' . $item->path) }}" type="video/webm">
                        Your browser does not support HTML5 video.
                    </video>
                </a>
            </div>
        @else
            <div class="col-lg-12 text-center" style="padding: 20px 0 20px 0;">
                <a target="_blank" rel="noopener" href="{{url('/img/' . $item->path)}}"><img
                            class="img-responsive rounded img-a" src="{{  url('/img/' . $item->path) }}"></a>
            </div>
        @endif

    @endforeach

@endsection

@section('footer')
    <nav class="text-center">
        <hr>

        <div class="col-md-6 offset-md-3">
            <a id="delete-album-href" href="#" onclick="toggleShow(); return false;">Delete?</a>
        </div>

        <div class="col-md-6 offset-md-3 text-left" id="delete-album-div">
            <form action="{{ route('postAlbumDelete', ['alias' => $album->alias]) }}" method="post">
                @csrf
                <fieldset class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="optionsRadios" id="tokenRadio"
                                   value="token" onclick="showTokenForm();">
                            Use token
                        </label>
                    </div>
                    <div class="form-group" id="tokenForm">
                        <input type="text" class="form-control" id="token" name="token">
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="optionsRadios" id="passwordRadio"
                                   value="password" onclick="showPasswordForm();">
                            Use password
                        </label>
                    </div>
                    <div class="form-group" id="passwordForm">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Delete</button>
            </form>
        </div>
    </nav>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/f.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/clipboard.min.js') }}"></script>
    <script>
        new ClipboardJS(document.getElementById('btn'));
    </script>
@endsection
