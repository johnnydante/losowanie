<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rodzinne losowanie</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Signika+Negative" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
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
                            <form action="{{ route('sendMailPairs') }}" method="get" style="float: left; margin-left: 20px;">
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Czy napewno chcesz wysłać wszystkim użytkownikom e-mail z zaproszeniem do losowania?')">Wyślij maile</button>
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
                        @if(Auth::user()->isAdmin())
                            <form action="{{ route('users') }}" method="get" style="float: right; margin-right: 20px;">
                                <button type="submit" class="btn btn-outline-primary" >Użytkownicy</button>
                            </form>
                        @endif
					@endauth
                </div>
            </div>
        </nav>

        <div class="card-body">

            @yield('content')

        </div>
    </div>
</body>
</html>
