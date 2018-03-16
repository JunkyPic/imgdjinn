@extends('layout.base')

@section('title')
    Images
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
                        <div class="col-lg-12">
                            <a href="{{ route('showImage', ['alias' => $image->alias]) }}">
                                <img class="img-responsive rounded img-a" src="{{  url('/img/' . $image->path ) }}">
                            </a>
                        </div>
                        <div class="col-lg-12 mrg-top">
                            <form action="{{ route('userPostImageDelete', ['alias' => $image->alias]) }}" method="post">
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
                {{ $images->links() }}
            </div>
        </div>
    @endif

@endsection
