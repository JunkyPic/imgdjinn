@extends('layout.base')

@section('title')
    Images
@endsection

@section('content')
    @foreach($images->chunk(2) as $chunk)
        {{-- get and display only the first image--}}
        <div class="row splitter">
            @foreach($chunk as $image)
                <div class="col-lg-6 text-center">
                    <small>Token: {{ null !== $image->token ? $image->token : 'No token found' }}</small>
                    <a href="{{ route('showImage', ['alias' => $image->alias]) }}">
                        <img class="img-responsive rounded img-a" src="{{  url('/img/' . $image->path ) }}">
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="row">
        <div class="col-lg-12 pagination pagination-centered justify-content-center">
            {{ $images->links() }}
        </div>
    </div>
@endsection
