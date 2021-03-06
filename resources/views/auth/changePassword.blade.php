@extends('layouts.app')

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="float: left; margin-top: 10px;">{{ __('Zmiana hasła') }}</h5>
                            @if(Auth::user()->logged > 1)
                                <a href='{{ route('myDatas') }}' class="btn btn-outline-primary" style="float: right; margin-top: 3px;">
                                    {{ __('Powrót') }}
                                </a>
                            @endif
                        </div>

                        <div class="card-body inner-datas">
                            @include('flash-messages')
                            <form method="POST" action="{{ route('changePassword.post') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Stare hasło') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('oldPassword') ? ' is-invalid' : '' }}" name="oldPassword" required>

                                        @if ($errors->has('oldPassword'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('oldPassword') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nowe hasło') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Powtórz nowe hasło') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div style="text-align: center;">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Zapisz zmiany') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
