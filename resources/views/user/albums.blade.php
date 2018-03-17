@extends('layout.base')

@section('title')
    Albums
@endsection

@section('content')

    @if(Session::has('error'))
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="alert alert-danger">
                    <strong>{{ Session::get('error') }}</strong>
                </div>
            </div>
        </div>
    @endif

    @if(Session::has('success'))
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="alert alert-info">
                    <strong>{{ Session::get('success') }}</strong>
                </div>
            </div>
        </div>
    @endif

    @if($albums->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <h2 class="display-5 text-center text-muted">No albums found</h2>
            </div>
        </div>
    @else
        @foreach($albums->chunk(2) as $chunk)
            {{-- get and display only the first image--}}
            <div class="row splitter">
                @foreach($chunk as $album)
                    <div class="col-lg-6 text-center">
                        <div class="col-lg-12">
                            <span class="badge badge-info">Has password - <small>{{ null === $album->password ? 'No' : 'Yes' }}</small></span>
                            <span class="badge badge-info">Token - <small>{{ null === $album->token ? 'No token found' :  $album->token}}</small></span>
                        </div>
                        <div class="col-lg-12">
                            @if(strstr($album->images()->first()->path, '.webm'))
                                <a href="{{ route('showAlbum', ['alias' => $album->alias]) }}">
                                    <video width="100%" controls autoplay loop>
                                        <source src="{{  url('/img/' . $album->images()->first()->path) }}" type="video/webm">
                                        Your browser does not support HTML5 video.
                                    </video>
                                </a>
                            @else
                                <a href="{{ route('showAlbum', ['alias' => $album->alias]) }}">
                                    <img class="img-responsive rounded img-a" src="{{  url('/img/' . $album->images()->first()->path ) }}">
                                </a>
                            @endif
                        </div>
                        <div class="col-lg-12 mrg-top">
                            <form action="{{ route('userPostAlbumDelete', ['alias' => $album->alias]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-lg btn-block">Delete</button>
                                <fieldset class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            @foreach($errors->all() as $message)
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                                <br>
                                            @endforeach
                                            <input type="checkbox" class="form-check-input" name="confirm">
                                            <small>I understand that I cannot undo this action</small>
                                        </label>

                                    </div>
                                </fieldset>

                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        <div class="row">
            <div class="col-lg-12 pagination pagination-centered justify-content-center">
                {{ $albums->links() }}
            </div>
        </div>
    @endif

@endsection
