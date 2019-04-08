@extends('layouts.app')

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="float: left; margin-top: 10px;">{{ __('Edytuj Dane') }}</h5>
                            <a href='{{ route('myDatas') }}' class="btn btn-outline-primary" style="float: right; margin-top: 3px;">
                                {{ __('Powrót') }}
                            </a>
                        </div>

                        <div class="card-body inner-datas">
                            @include('flash-messages')
                            <form method="post" action="{{ route('myDatas.post') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Imię') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" value="{{old('name', Auth::user()->name)  }}" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" value="{{old('email', Auth::user()->email)  }}" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="birthday" class="col-md-4 col-form-label text-md-right">{{ __('Urodziny') }}</label>

                                    <div class="col-md-6">
                                        <input id="birthday" value="{{old('birthday', Auth::user()->birthday)  }}" type="date" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" name="birthday" required>

                                        @if ($errors->has('birthday'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('birthday') }}</strong>
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
