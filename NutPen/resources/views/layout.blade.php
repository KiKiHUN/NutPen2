<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NutPen enapló</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <link href="/FA_6.2.0_web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/mainStyle.css">
    <link rel="stylesheet" href="/css/bannerStyle.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="/css/datatables.min.css"/>


    <link rel="stylesheet" href="/css/jquery-calendar.min.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
    <link rel="stylesheet" href="/css/solid.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
   
</head>

<body id="reportsPage">
    <div class="" id="home">
        <nav class="navbar navbar-expand-xl">
            <div class="container h-100">
                <a class="navbar-brand" href="/">
                    <h1 class="tm-site-title mb-0">Nutpen e-napló</h1>
                </a>
                <a title="Teljes képernyős mód" id="fullscreentoggle"> <i class="fa-solid fa-expand"></i></a>
               
                <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars tm-nav-icon"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto h-100">
                    

                        
                       @yield('navbar')
                               
                    </ul>

                </div>
            </div>

        </nav>
        <div class="container">
            @if (session()->has('successmessage'))
                <div class="alert alert-success">
                    {{ session()->get('successmessage') }}
                </div>
            @endif
            @if (session()->has('failedmessage'))
                <div class="alert alert-warning">
                    {{ session()->get('failedmessage') }}
                </div>
            @endif

            @include('calendar')
            
            @yield('content')
        </div>
        <footer class="tm-footer row tm-mt-small">
            <div class="col-12 font-weight-light">
                <p class="text-center text-white mb-0 px-4 small">
                    Copyright &copy; <b>2024</b> Minden jog fenntartva.

                    Készítette: Rába Krisztián
                </p>
            </div>
        </footer>
    </div>




<!--  scriptek -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="/js/jquery-3.3.1.min.js"  type="text/javascript"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/Chart.min.js"></script>

    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/tooplate-scripts.js"></script>
    <script type="text/javascript" src="/js/datatables.min.js"></script>
    
    <script src="/js/jquery-calendar.min.js"></script>
    <script src="/js/jquery.touchSwipe.min.js"></script>
    <script src="/js/moment.withlocales.js"></script>
    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>

    <script>
        $( "#fullscreentoggle" ).on( "click", function() {
            toggleFullScreen();
          } );
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen({
                    navigationUI: "hide"
                })
            } else if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    </script>

    @yield('script')
<!--  scriptek -->

</body>

</html>
