<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Losowanie</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Signika+Negative" rel="stylesheet">
</head>
<body>
    <div id="app" >
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container" >
                <div class="right" style="width: 100%;">
					@auth
						@if(Auth::user()->isAdmin())
							<form action="{{ route('shuffle') }}" method="get" style="float: left;">
								<button type="submit" class="btn btn-outline-danger" onclick="return confirm('Czy napewno chcesz wykonać nowe tasowanie?')">Nowe tasowanie</button>
							</form>
                            @if(Auth::user()->canTakeName())
                                <form action="{{ route('delete') }}" method="get" style="float: left; margin-left: 20px;">
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Czy napewno chcesz usunąć wszystkie pary?')">Usuń pary</button>
                                </form>
                            @endif
						@endif
						<a class="btn btn-outline-dark" href="{{ route('logout') }}" style="float: right;"
						   onclick="event.preventDefault();
										 document.getElementById('logout-form').submit();">
							{{ __('Wyloguj') }}
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form> 
					@endauth
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            @auth
                                <div class="card-header">
                                    <h5 style="float: left; margin-top: 10px;">Witaj {{ Auth::user()->name }}</h5>
                                    @if(URL::current() != 'http://losowanie.local/changePassword')
                                        <form action="{{ route('passwordChange') }}" method="get">
                                            <button type="submit" class="btn btn-outline-primary" style="float: right;">Zmień hasło</button>
                                        </form>
                                    @endif
                                </div>
                            @endauth
                            <div class="card-body">

                                @include('flash-messages')
                                @yield('content')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
