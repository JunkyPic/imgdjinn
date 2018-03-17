@extends('layout.base')
@section('title')
    Upload
@endsection
@section('content')
<div class="col-md-6 offset-md-3">
    @if(Session::has('album_delete_success'))
        <div class="alert alert-info text-center">
            {{Session::get('album_delete_success')}}
        </div>
    @endif
    @if(Session::has('image_delete_success'))
        <div class="alert alert-info text-center">
            {{Session::get('image_delete_success')}}
        </div>
    @endif

    @foreach($errors->all() as $message)
        <div class="alert alert-danger text-center">
            {{ $message}}
        </div>
    @endforeach

    <form action="{{ route('postUpload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="btn btn-primary btn-lg btn-block">
                Add image(s)<input type="file" class="form-control-file" id="img" aria-describedby="fileHelp"
                                   name="img[]"
                                   multiple hidden>
            </label>
        </div>

        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="optionsRadios" id="tokenNone" value="none"
                       onclick="hidePasswordInput(); showNoneText();" checked="checked">
                Don't create a token or password
                <small id="none" class="form-text text-muted">You(or anyone else for that matter) won't be able
                    to delete this image/album
                </small>
            </label>
        </div>

        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="optionsRadios" id="tokenRadio" value="token"
                       onclick="hidePasswordInput();">
                    Auto-generate a delete token
            </label>
        </div>

        <fieldset class="form-group">
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="optionsRadios" id="passwordRadio"
                           value="password" onclick="showPasswordInput();">
                    Allow me to enter a password
                </label>
            </div>

            <div class="form-group" id="passwordForm">
                <input type="password" class="form-control" id="password" name="password"
                       aria-describedby="passwordHelp">
            </div>
        </fieldset>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Upload</button>
    </form>
</div>
@endsection

@section('footer')

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/upload.js') }}"></script>
@endsection
