<!DOCTYPE html>
<html lang="en">

<head>
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
    <!--
	Product Admin CSS Template
	https://templatemo.com/tm-524-product-admin
	-->
</head>

<body id="reportsPage">
    <div class="" id="home">
        <nav class="navbar navbar-expand-xl">
            <div class="container h-100">
                <a class="navbar-brand" href="/">
                    <h1 class="tm-site-title mb-0">Nutpen e-napló</h1>
                </a>
                <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars tm-nav-icon"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto h-100">
                        <li class="nav-item">
                            <a class="nav-link " href="/vezerlopult">
                                <i class="fa-solid fa-house-chimney"></i>
                                Főoldal
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>

                        
                       @yield('navbar')


                       <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i>
                            <span>
                                Beállítások <i class="fas fa-angle-down"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/fiok">Fiók</a>
                            <a class="dropdown-item" href="/logout">Kilépés</a>
                        </div>
                    </li>
                    </ul>

                </div>
            </div>

        </nav>
        <div class="container">
            @yield('content')
        </div>
        <footer class="tm-footer row tm-mt-small">
            <div class="col-12 font-weight-light">
                <p class="text-center text-white mb-0 px-4 small">
                    Copyright &copy; <b>2023</b> Minden Incidens fenntartva.

                    Készítette: KiKi1HUN
                </p>
            </div>
        </footer>
    </div>




<!--  scriptek -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/Chart.min.js"></script>

    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/tooplate-scripts.js"></script>
    <script type="text/javascript" src="/js/datatables.min.js"></script>

    @yield('script')
<!--  scriptek -->

</body>

</html>
