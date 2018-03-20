@extends('layout.base')

@section('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Images
@endsection

@section('content')
    <div class="col-lg-12">
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

        @if($images->count() == 0)
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="display-5 text-center text-muted">No images found</h2>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-2 splitter">
                    <button type="submit" id="image__delete_btn" class="btn btn-danger btn-lg btn-block" value="0">Delete</button>
                </div>
            </div>
            <div id="image__delete">
                @foreach($images->chunk(3) as $chunk)
                    {{-- get and display only the first image--}}
                    <div class="row splitter">
                        @foreach($chunk as $image)
                            <div class="col-lg-4 text-center">
                                <div class="col-lg-12">
                                    @if(strstr($image->path, '.webm'))
                                        <a class="image__select" href="{{ route('showImage', ['alias' => $image->alias]) }}" id="{{ $image->alias }}">
                                            <video width="100%" controls autoplay loop>
                                                <source src="{{  url('/img/' . $image->path) }}" type="video/webm">
                                                Your browser does not support HTML5 video.
                                            </video>
                                        </a>
                                    @else
                                        <a class="image__select" href="{{ route('showImage', ['alias' => $image->alias]) }}" id="{{ $image->alias }}">
                                            <img class="img-responsive rounded img-a" src="{{  url('/img/' . $image->path ) }}">
                                        </a>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12 pagination pagination-centered justify-content-center">
                    {{ $images->links() }}
                </div>
            </div>
        @endif
    </div>
<input type="hidden" value="{{route('userPostImageDelete')}}" id="image__delete_route">

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/images.js') }}"></script>
@endsection