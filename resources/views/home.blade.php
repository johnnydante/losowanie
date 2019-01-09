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
                            <button type="submit" action="{{ route('shuffle') }}" class="btn btn-warning">Nowe tasowanie</button>
                        </form>
                    @endif
                        <p>You are logged in!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
