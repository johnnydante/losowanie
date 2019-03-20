@extends('layouts.app')

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="float: left; margin-top: 10px;">{{ __('Mój e-mail') }}</h5>
                            <a href='{{ route('home') }}' class="btn btn-outline-primary" style="float: right; margin-top: 3px;">
                                {{ __('Powrót') }}
                            </a>
                        </div>

                        <div class="card-body inner">
                            @include('flash-messages')
                            <p style="text-align: center; font-size: 18px; margin-top: 15px;">{{ Auth::user()->email }}</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
