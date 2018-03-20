@extends('layout.base')

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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
        <div class="row">
            <div class="col-lg-2 splitter">
                <button type="submit" id="album__delete_btn" class="btn btn-danger btn-lg btn-block" value="0">Delete</button>
            </div>
        </div>

        <div id="album__delete">
            @foreach($albums->chunk(4) as $chunk)
                <div class="row splitter">
                    @foreach($chunk as $album)
                        <div class="col-lg-3 text-center">
                            <div class="col-lg-12">
                                @if(strstr($album->images()->first()->path, '.webm'))
                                    <a class="album__select" href="{{ route('showAlbum', ['alias' => $album->alias]) }}" id="{{ $album->alias }}">
                                        <video width="100%" controls autoplay loop>
                                            <source src="{{  url('/img/' . $album->images()->first()->path) }}" type="video/webm">
                                            Your browser does not support HTML5 video.
                                        </video>
                                    </a>
                                @else
                                    <a class="album__select" href="{{ route('showAlbum', ['alias' => $album->alias]) }}"  id="{{ $album->alias }}">
                                        <img class="img-responsive rounded img-a" src="{{  url('/img/' . $album->images()->first()->path ) }}">
                                    </a>
                                @endif
                            </div>
                            <div class="col-lg-12 mrg-top">
                                <form action="{{ route('userPostAlbumDelete', ['alias' => $album->alias]) }}" method="post">
                                    @csrf
                                    <fieldset class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                @foreach($errors->all() as $message)
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    <br>
                                                @endforeach
                                            </label>
                                        </div>
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-12 pagination pagination-centered justify-content-center">
                {{ $albums->links() }}
            </div>
        </div>
    @endif
    <input type="hidden" value="{{route('userPostAlbumDelete')}}" id="album__delete_route">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/albums.js') }}"></script>
@endsection