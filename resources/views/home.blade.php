@extends('layout.base')
@section('title')
    Home
@endsection

@section('css')
    <link href="{{ asset('css/bootstraponoffbtn.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="col-md-6 offset-md-3">
        <form action="{{ route('home') }}" method="get" class="form-inline">
            <select class="form-control mb-2 mr-sm-2 mb-sm-0" name="f_ord">
                <option value="nf" @if(Request::has('f_ord') && Request::get('f_ord') == 'nf') selected @endif>Newest first</option>
                <option value="of" @if(Request::has('f_ord') && Request::get('f_ord') == 'of') selected @endif>Oldest first</option>
            </select>
            <select class="form-control mb-2 mr-sm-2 mb-sm-0" name="f_nsfw">
                <option value="nn" @if(Request::has('f_nsfw') && Request::get('f_nsfw') == 'nn') selected @endif>No NSFW</option>
                <option value="mi" @if(Request::has('f_nsfw') && Request::get('f_nsfw') == 'mi') selected @endif>Mixed</option>
                <option value="ns" @if(Request::has('f_nsfw') && Request::get('f_nsfw') == 'ns') selected @endif>Only NSFW</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <div class="col-md-12">
        <div class="infinite-scroll">
            @foreach($images->chunk(4)  as $chunk)
                <div class="row splitter">
                    @foreach($chunk as $image)
                        <div class="col-lg-3 text-center">
                            @if(strstr($image->path, '.webm'))
                                <a href="{{ route('showImage', ['alias' => $image->alias]) }}">
                                    <video width="100%" controls autoplay loop>
                                        <source src="{{  url('/img/' . $image->path) }}" type="video/webm">
                                        Your browser does not support HTML5 video.
                                    </video>
                                </a>
                            @else
                                <a href="{{ route('showImage', ['alias' => $image->alias]) }}">
                                    <img class="img-responsive rounded img-a" src="{{  url('/img/' . $image->path ) }}">
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="row">
                <div class="col-lg-12 pagination pagination-centered justify-content-center">
                    {{ $images->appends(Request::all())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/bootstraponoffbtn.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#allow_nsfw').bootstrapToggle({
                on: 'NSFW',
                off: 'SFW'
            });
        });
    </script>
@endsection

