@extends('layouts.app')

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="float: left; margin-top: 10px;">{{ __('Moje konto') }}</h5>
{{--                            <a href='{{ route('home') }}' class="btn btn-outline-primary" >
                                {{ __('Powrót') }}
                            </a>--}}
                            <form action="{{ route('passwordChange') }}" method="get">
                                <button type="submit" class="btn btn-outline-primary" style="float: right; margin-top: 3px; margin-left: 15px;">Zmień hasło</button>
                            </form>
                            <a href='{{ route('changeDatas') }}' class="btn btn-outline-primary" style="float: right; margin-top: 3px;">
                                {{ __('Edytuj dane') }}
                            </a>
                        </div>

                        <div class="card-body inner-datas">
                            @include('flash-messages')
                            <p style="text-align: left; font-size: 18px; margin-left: 20px;">
                                <b>Imię: &nbsp;&nbsp;</b> {{ Auth::user()->name }}
                            </p>
                            <p style="text-align: left; font-size: 18px; margin-top: 10px; margin-left: 20px;">
                                <b>E-mail: &nbsp;&nbsp;</b><br>
                                {{ Auth::user()->email }}
                            </p>
                            <p style="text-align: left; font-size: 18px; margin-top: 10px; margin-left: 20px;">
                                <b>Urodziny: &nbsp;&nbsp;</b><br>
                                {!! Auth::user()->birthday ? date("d. m. Y", strtotime(Auth::user()->birthday)).'r. &nbsp;('.\Globals::getDayOfWeek(Auth::user()->birthday).')' : '-' !!}
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
