<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ciisa</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
            <img width="50px" height="50px" src="data:image/png;base64,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" alt="Ciisa">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Beneficios estudiantiles
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
