<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de supermercado Sumermarketm&b">
    <meta name="author" content="Sumermarketm&b.com">
    <meta name="keyword" content="Sumermarketm&b">
    <link rel="shortcut icon" href="img/favicon.png">
    <!-- Id for Channel Notification -->
    <meta name="userId" content="{{ Auth::check() ? Auth::user()->id : ''}}">

    <title>Sumermarketm&b - Grupo 3</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js">
    <!-- Icons -->
    <link href="css/plantilla.css" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
        <header class="app-header navbar">
            <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="nav navbar-nav d-md-down-none">
                <li class="nav-item px-3">
                    <a class="nav-link" href="#">Escritorio</a>
                    <form class="form-horizontal was-validated" method="GET" action="{{ route('coreo')}}">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">Contacto</button>
                            </div>
                        </div>
                    </form>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#">Configuraciones</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <notification :notifications="notifications"></notification>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                        <span class="d-md-down-none">{{Auth::user()->usuario}} </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Cuenta</strong>
                        </div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-lock"></i> Cerrar sesión</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </header>

        <div class="app-body">

            @if(Auth::check())
            @if (Auth::user()->idrol == 1)
            @include('plantilla.sidebaradministrador')
            @elseif (Auth::user()->idrol == 2)
            @include('plantilla.sidebarvendedor')
            @elseif (Auth::user()->idrol == 3)
            @include('plantilla.sidebaralmacenero')
            @elseif (Auth::user()->idrol == 4)
            @include('plantilla.sidebardelivery')
            @elseif (Auth::user()->idrol == 5)
            @include('plantilla.sidebarcliente')
            @else

            @endif

            @endif
            <!-- Contenido Principal -->
            @yield('contenido')
            <!-- /Fin del contenido principal -->
        </div>
    </div>
    <footer class="app-footer">
        <span><a href="#">Grupo 3</a> &copy; 2022</span>
        <span class="ml-auto">Desarrollado por <a href="#">Grupo 3</a></span>
    </footer>

    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
</body>

</html>