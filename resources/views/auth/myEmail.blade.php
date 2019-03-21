@extends('layouts.app')

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="float: left; margin-top: 10px;">{{ __('Mój e-mail') }}</h5>
                            <a href='{{ route('home') }}' class="btn btn-outline-primary" style="float: right; margin-top: 3px;">
                                {{ __('Powrót') }}
                            </a>
                        </div>

                        <div class="card-body inner">
                            @include('flash-messages')
                            <p style="text-align: center; margin-left: 30px; font-size: 18px; margin-top: 15px; float: left">{{ Auth::user()->email }}</p>

                            <a href='{{ route('changeMail') }}' class="btn btn-dark" style="float: right; margin-right: 20px; margin-top: 12px; margin-left: 10px;">
                                {{ __('Edytuj') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
