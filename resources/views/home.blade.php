@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Witaj {{ Auth::user()->name }}!  </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(Auth::user()->isAdmin())
                        <form action="{{ route('shuffle') }}" method="get">
                            <button type="submit" class="btn btn-outline-danger">Nowe tasowanie</button>
                        </form>
                    @endif

                    @if(!Auth::user()->hasTaken())
                        <form action="{{ route('getPair') }}" method="get">
                            <button type="submit" class="btn btn-outline-success">Wylosuj dla mnie osobę</button>
                        </form>
                    @else
                        <p>Osoba, którą wylosowałeś, to: <b>{{ Auth::user()->getMyPair() }}</b>! </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
