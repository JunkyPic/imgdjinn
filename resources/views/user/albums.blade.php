@extends('layout.base')

@section('title')
    Albums
@endsection

@section('content')
    @foreach($albums->chunk(2) as $chunk)
        {{-- get and display only the first image--}}
        <div class="row splitter">
            @foreach($chunk as $album)
                <div class="col-lg-6 text-center">
                    <small>Token: {{ null !== $album->token ? $album->token : 'No token found' }}</small>
                    <a href="{{ route('showAlbum', ['alias' => $album->alias]) }}">
                        <img class="img-responsive rounded img-a" src="{{  url('/img/' . $album->images()->first()->path ) }}">
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="row">
        <div class="col-lg-12 pagination pagination-centered justify-content-center">
            {{ $albums->links() }}
        </div>
    </div>
@endsection
