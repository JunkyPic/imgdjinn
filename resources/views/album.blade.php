@extends('layout.base')

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
            This is your token for this album. Don't lose it or you won't be able to delete this album.
            <br>
            <br>
            <strong>{{ $album->token }}</strong>
            <br>
            <button type="button" id="btn" data-clipboard-text="{{ $album->token }}" class="btn btn-primary btn-lg btn-block">Copy token</button>
        </div>
    @endif

    @foreach($album->images()->get() as $item)
        <div class="col-lg-12 text-center" style="padding: 20px 0 20px 0;">
            <a target="_blank" rel="noopener noreferrer" href="{{route('showImage', ['alias' => $item->alias])}}"><img
                        class="img-responsive rounded img-a" src="{{  url('/img/' . $item->path) }}"></a>
        </div>
    @endforeach

@endsection

@section('footer')
    <nav class="text-center">
        <hr>

        <div class="col-md-6 offset-md-3">
            <a id="delete-album-href" href="#" onclick="toggleShow(); return false;">Delete?</a>
        </div>

        <div class="col-md-6 offset-md-3 text-left" id="delete-album-div">
            <form action="{{ action('AlbumController@delete', ['alias' => $album->alias]) }}" method="post">
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
