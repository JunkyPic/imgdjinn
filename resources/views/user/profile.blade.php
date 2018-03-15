@extends('layout.base')

@section('title')
    Profile
@endsection

@section('content')

    @if(Session::has('error'))
        <div class="alert alert-danger col-lg-6 offset-lg-3">
            {{Session::get('error')}}
        </div>
    @endif

    @if(Session::has('success'))
        <div class="alert alert-info col-lg-6 offset-lg-3">
            {{Session::get('success')}}
        </div>
    @endif

    <div class="col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-header">{{ __('Change password') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('changePassword') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="cpassword" class="col-md-4 col-form-label text-md-right">{{ __('Current password') }}</label>

                        <div class="col-md-6">
                            <input id="cpassword" type="password" class="form-control{{ $errors->has('cpassword') ? ' is-invalid' : '' }}" name="cpassword" required>

                            @if ($errors->has('cpassword'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('cpassword') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection

