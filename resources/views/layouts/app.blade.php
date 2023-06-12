<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ url('bootstrap/dist/css/bootstrap.css') }}" >
    <style type="text/css">

            @font-face {
                font-family: "ShopifySans";
                src: url("./bootstrap/fonts/ShopifySans--regular.woff2") format("woff2");
                font-style: normal;
                font-weight: 400;
                font-display: swap
            }

            @font-face {
                font-family: "ShopifySans";
                src: url("./bootstrap/fonts/ShopifySans--medium.woff2") format("woff2");
                font-style: normal;
                font-weight: 500;
                font-display: swap
            }

            @font-face {
                font-family: "ShopifySans";
                src: url("./bootstrap/fonts/ShopifySans--bold.woff2") format("woff2");
                font-style: normal;
                font-weight: 700;
                font-display: swap
            }

            @font-face {
                font-family: "ShopifySans";
                src: url("./bootstrap/fonts/ShopifySans--extrabold.woff2") format("woff2");
                font-style: normal;
                font-weight: 800;
                font-display: swap
            }

            @font-face {
                font-family: "ShopifySans";
                src: url("./bootstrap/fonts/ShopifySans--black.woff2") format("woff2");
                font-style: normal;
                font-weight: 900;
                font-display: swap
            }
            body,html{
                font-family: ShopifySans, Helvetica, Arial, sans-serif;
                font-size: 1.1em;
            }
            .bg-section{
              background-color: #004c3f;
            }
    </style>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="{{ url('bootstrap/dist/js/bootstrap.js') }}"></script>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand p-0" href="{{ url('/') }}"><b>{{config('app.name')}}</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="mt-3">
        @yield('content')
    </main>

    
</body>
</html>