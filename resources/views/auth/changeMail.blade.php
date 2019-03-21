@extends('layouts.app')

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="float: left; margin-top: 10px;">{{ __('Edytuj e-mail') }}</h5>
                            <a href='{{ route('myEmail') }}' class="btn btn-outline-primary" style="float: right; margin-top: 3px;">
                                {{ __('Powrót') }}
                            </a>
                        </div>

                        <div class="card-body inner">
                            @include('flash-messages')
                            <form method="post" action="{{ route('myEmail.post') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Mój e-mail') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" value="{{old('email', Auth::user()->email)  }}" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div style="text-align: center;">
                                    <button type="submit" class="btn btn-primary" style=" margin-top: 3px;">
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
