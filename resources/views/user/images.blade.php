@extends('layout.base')

@section('title')
    Images
@endsection

@section('content')
    @if($images->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <h2 class="display-5 text-center text-muted">No images found</h2>
            </div>
        </div>
    @else
        @foreach($images->chunk(3) as $chunk)
            {{-- get and display only the first image--}}
            <div class="row splitter">
                @foreach($chunk as $image)
                    <div class="col-lg-4 text-center">
                        <div class="col-lg-12">
                            <span class="badge badge-info">Has password - <small>{{ null === $image->password ? 'No' : 'Yes' }}</small></span>
                            <span class="badge badge-info">Token - <small>{{ null === $image->token ? 'No token found' :  $image->token}}</small></span>
                        </div>
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
    @endif

@endsection
