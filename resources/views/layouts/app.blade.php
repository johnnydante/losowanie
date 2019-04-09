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
                    <a href="{{ route('home') }}" class="btn btn-outline-success" style="max-height: 36px; max-width: 166px;">
                        <i class="fas fa-gift logo main-page-btn" style="float: left; margin-top: -4px; font-size: 28px; color: #00bb4d; padding: -5px;"></i>
                        <span style="margin-top: -6px;" class="btn">Strona główna</span>
                    </a>

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
                            <form action="{{ route('users') }}" method="get" style="float: left; margin-left: 5px;">
                                <button type="submit" class="btn btn-outline-primary" >Uczestnicy losowania</button>
                            </form>

                            <form action="{{ route('birthdays') }}" method="get" style="float: left; margin-left: 5px;">
                                <button type="submit" class="btn btn-outline-primary" >Urodziny</button>
                            </form>

                            <?php
                            $useragent=$_SERVER['HTTP_USER_AGENT'];
                            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {

                            } else {
                                echo '<form action="'.route('snake').'" method="get" style="float: left; margin-left: 5px;">
                                        <button type="submit" class="btn btn-outline-dark" >Snake</button>
                                    </form>';
                            }
                            ?>
                            @if(Auth::user()->isAdmin())

                                @if(Auth::user()->canTakeName())
                                    <form action="{{ route('sendMailPairs') }}" method="get" style="float: left; margin-left: 5px;">
                                        <button id="sendMails" type="submit" class="purple btn btn-outline">Wyślij zaproszenia</button>
                                    </form>
                                @endif
                                <form action="{{ route('shuffle') }}" method="get" style="float: left; margin-left: 5px;">
                                    <button type="submit" class="btn btn-outline-danger" id="shuffle">Nowe tasowanie</button>
                                </form>
                                @if(Auth::user()->canTakeName())
                                    <form action="{{ route('resetShuffle') }}" method="get" style="float: left; margin-left: 5px;">
                                        <button type="submit" class="btn btn-outline-danger" id="resetShuffle">Resetuj losowanie</button>
                                    </form>
                                @endif
                            @endif
                        </ul>
                        @if(Auth::user()->logged > 1)
                            <a  href="{{ route('logout') }}"  class="btn btn btn-outline-dark" style="float: left; max-height: 36px; min-width: 112px; margin-left: 5px;"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                <i class="fas fa-power-off  my-logout" style="margin-top: 1px; margin-left: -15px; font-size: 22px; color: #333333"></i>
                                <span style="float: left; margin-right: 20px;">Wyloguj</span>
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
