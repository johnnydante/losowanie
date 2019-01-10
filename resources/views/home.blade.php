@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					<h5 style="float: left; margin-top: 10px;"><b>Witaj {{ Auth::user()->name }}!</b></h5>
					<form action="{{ route('passwordChange') }}" method="get">
						<button type="submit" class="btn btn-outline-primary" style="float: right;">Zmień hasło</button>
					</form>
				</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    

                    @if(!Auth::user()->hasTaken())
                        <form action="{{ route('getPair') }}" method="get">
                            <button type="submit" class="btn btn-outline-success">Wylosuj dla mnie osobę</button>
                        </form>
                    @else
							<h3>Osoba, którą wylosowałeś, to: <b>{{ Auth::user()->getMyPair() }}</b>! </h3>
						<div>
							@if(Auth::user()->getMyPairSuggestions())
								<h4 style="margin-top: 40px;">Sugestie prezentów, które podała ta osoba, to: </h4>
								@if(Auth::user()->getMyPairSuggestions()->first)
									<h5>- {{ Auth::user()->getMyPairSuggestions()->first }}</h5>
								@endif
								@if(Auth::user()->getMyPairSuggestions()->second)
									<h5>- {{ Auth::user()->getMyPairSuggestions()->second }}</h5>
								@endif
								@if(Auth::user()->getMyPairSuggestions()->third)
									<h5>- {{ Auth::user()->getMyPairSuggestions()->third }}</h5>
								@endif
							@else
								<h4 style="margin-top: 40px;">Ta osoba nie podała jeszcze żadnych sugestii prezentów</h4>
							@endif
						</div>
							@if(!Auth::user()->hasAllSuggestions())
								<h5 style="margin-top: 40px;">Jeżeli chcesz, możesz podać 3 sugestie prezentu dla osoby, która wylosuje Ciebie:</h5>
							@else
							<h4 style="margin-top: 40px;">Twoje sugestie to:</h4>
							@endif
                        <div>
                            <form action="{{ route('postSuggestion') }}" method="post">
                                @if(Auth::user()->hasFirstSuggestions())
                                    <h5>
                                        1) {{ Auth::user()->getMyFirstSuggestion() }}
										<a href='{{ route('changeOneSuggest', ['suggest' => 'first']) }}' class="btn btn-outline-info" style="margin-left: 10px;">Cofnij</a>
                                    </h5>
                                @else
									<p>1) <input type="text" class="suggestion" placeholder="Wpisz pierwszą sugstię" id="first" name="first"></p>
                                @endif
                                @if(Auth::user()->hasSecondSuggestions())
                                    <h5>
                                        2) {{ Auth::user()->getMySecondSuggestion() }}
										<a href='{{ route('changeOneSuggest', ['suggest' => 'second']) }}' class="btn btn-outline-info" style="margin-left: 10px;">Cofnij</a>
                                    </h5>
                                @else
                                    <p>2) <input type="text" class="suggestion" placeholder="Wpisz drugą sugstię" id="second" name="second"></p>
                                @endif
                                @if(Auth::user()->hasThirdSuggestions())
                                    <h5>
                                        3) {{ Auth::user()->getMyThirdSuggestion() }}
										<a href='{{ route('changeOneSuggest', ['suggest' => 'third']) }}' class="btn btn-outline-info" style="margin-left: 10px;">Cofnij</a>
                                    </h5>
                                @else
									<p>3) <input type="text" class="suggestion" placeholder="Wpisz trzecią sugstię" id="third" name="third"></p>
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
