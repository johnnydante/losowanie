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

    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">

    </script>

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
        @auth
            <nav id="navi" class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container" >
                    <a href="{{ route('home') }}"> <i class="fas fa-gift logo" style="float: left; margin-left: 20px; font-size: 32px; margin-right: 20px; color: #00bb4d"></i></a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto" style="text-align: left; width: 100%">
                            <!-- Authentication Links -->
                            @if(Auth::user()->isAdmin())
                                <form action="{{ route('users') }}" method="get" style="float: left; margin-left: 10px;">
                                    <button type="submit" class="btn btn-outline-primary" >Uczestnicy losowania</button>
                                </form>
                            @else
                                    <form action="{{ route('users') }}" method="get" style="float: left; margin-left: 10px;">
                                        <button type="submit" class="btn btn-outline-success" >Uczestnicy losowania</button>
                                    </form>
                            @endif
                            @if(Auth::user()->isAdmin())

                                @if(Auth::user()->canTakeName())
                                    <form action="{{ route('sendMailPairs') }}" method="get" style="float: left; margin-left: 10px;">
                                        <button id="sendMails" type="submit" class="purple btn btn-outline">Wyślij zaproszenia</button>
                                    </form>
                                @endif
                                <form action="{{ route('shuffle') }}" method="get" style="float: left; margin-left: 10px;">
                                    <button type="submit" class="btn btn-outline-danger" id="shuffle">Nowe tasowanie</button>
                                </form>
                                @if(Auth::user()->canTakeName())
                                    <form action="{{ route('resetShuffle') }}" method="get" style="float: left; margin-left: 10px;">
                                        <button type="submit" class="btn btn-outline-danger" id="resetShuffle">Resetuj losowanie</button>
                                    </form>
                                @endif
                            @endif
                        </ul>
                        @if(Auth::user()->logged > 1)
                            <a class="btn btn-outline-dark" href="{{ route('logout') }}" style="float: left; margin-left: 10px;"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Wyloguj') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    </div>
                </div>
            </nav>
        @endauth

        <div class="card-body" id="mainCard">

            @yield('content')

        </div>
    </div>

    <script>
        $( document ).ready(function() {
            $('#sendMails').on('click', function () {
                var a = confirm('Czy napewno chcesz wysłać wszystkim użytkownikom e-mail z zaproszeniem do losowania?');
                if(a == true) {
                    $('#mainCard').parent().append("<div class='card-body' style='opacity:0.7; top: 30px;'>" +
                        "<main class='py-4'>"+
                            "<div class='container'>"+
                                "<div class='row justify-content-center'>"+
                                    "<div class='col-md-5'>"+
                                        "<div class='card' style='min-height:200px;'>"+
                                            " <div class='loader' style='padding: 30px; margin: auto; margin-top: 50px;'></div>" +
                                            "<h4 style='text-align: center; padding: 20px; margin-top: 30px;'>Proszę czekać, trwa wysyłanie e-maili</h4>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</main>");
                    $('#mainCard').hide();
                    $('#navi').hide();
                } else {
                    return false;
                }
            });
            $('#shuffle').on('click', function () {
                var a = confirm('Czy napewno chcesz wykonać nowe tasowanie?');
                if(a == true) {
                    $('#mainCard').parent().append("<div class='card-body' style='opacity:0.7; top: 30px;'>" +
                        "<main class='py-4'>"+
                        "<div class='container'>"+
                        "<div class='row justify-content-center'>"+
                        "<div class='col-md-5'>"+
                        "<div class='card' style='min-height:200px;'>"+
                        " <div class='loader' style='padding: 30px; margin: auto; margin-top: 50px;'></div>" +
                        "<h4 style='text-align: center; padding: 20px; margin-top: 30px;'>Proszę czekać, trwa tasowanie</h4>"+
                        "</div>"+
                        "</div>"+
                        "</div>"+
                        "</div>"+
                        "</main>");
                    $('#mainCard').hide();
                    $('#navi').hide();
                } else {
                    return false;
                }
            });
            $('#resetShuffle').on('click', function () {
                var a = confirm('Czy napewno chcesz zresetować losowanie?');
                if(a == true) {
                    $('#mainCard').parent().append("<div class='card-body' style='opacity:0.7; top: 30px;'>" +
                        "<main class='py-4'>"+
                        "<div class='container'>"+
                        "<div class='row justify-content-center'>"+
                        "<div class='col-md-5'>"+
                        "<div class='card' style='min-height:200px;'>"+
                        " <div class='loader' style='padding: 30px; margin: auto; margin-top: 50px;'></div>" +
                        "<h4 style='text-align: center; padding: 20px; margin-top: 30px;'>Proszę czekać, trwa resetowanie losowania</h4>"+
                        "</div>"+
                        "</div>"+
                        "</div>"+
                        "</div>"+
                        "</main>");
                    $('#mainCard').hide();
                    $('#navi').hide();
                } else {
                    return false;
                }
            });
        });
    </script>

</body>
</html>
