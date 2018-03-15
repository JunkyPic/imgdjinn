@extends('layout.base')

@section('title')
    Albums
@endsection

@section('content')
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
    @endif

@endsection
