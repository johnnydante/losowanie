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
                        <h3>Osoba, którą wylosowałeś, to: <b>{{ Auth::user()->getMyPair() }}</b>! </h3>

                        <h5>Jeżeli chcesz, możesz podać 3 sugestie prezentu dla osoby, która wylosuje Ciebie:</h5>
                        <div>
                            <form action="{{ route('postSuggestion') }}" method="post">
                                @if(Auth::user()->hasFirstSuggestions())
                                    <h5>
                                        1) {{ Auth::user()->getMyFirstSuggestion() }}
                                    </h5>
                                @else
                                <p><input type="text" class="suggestion" placeholder="Wpisz pierwszą sugstię" id="first" name="first"></p>
                                @endif
                                @if(Auth::user()->hasSecondSuggestions())
                                    <h5>
                                        1) {{ Auth::user()->getMySecondSuggestion() }}
                                    </h5>
                                @else
                                    <p><input type="text" class="suggestion" placeholder="Wpisz drugą sugstię" id="second" name="second"></p>
                                @endif
                                @if(Auth::user()->hasThirdSuggestions())
                                    <h5>
                                        1) {{ Auth::user()->getMyThirdSuggestion() }}
                                    </h5>
                                @else
                                        <p><input type="text" class="suggestion" placeholder="Wpisz trzecią sugstię" id="third" name="third"></p>
                                @endif
                                @if(!Auth::user()->hasAllSuggestions())
                                    <button type="submit" class="btn btn-outline-success">Wyślij</button>
                                @endif
                                @csrf
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
