<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('boostrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my.css') }}" rel="stylesheet">
    <!-- Scripts -->
    
    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>

    <script src="{{ asset('boostrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/my.js') }}"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"> </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    
</head>
<body>
    <div id="app">


        <nav class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container d-flex flex-wrap">
              <ul class="nav me-auto">
                @if(Auth::check() )
                    @if(auth()->user()->role == 1)
                        <li class="nav-item"><a href="/project" class="nav-link link-dark px-2 active" aria-current="page">My project </a></li>
                        <li class="nav-item"><a href="/history_donated" class="nav-link link-dark px-2 active" aria-current="page">History donates</a></li>
                    @elseif (auth()->user()->role == 0)   
                        <li class="nav-item"><a href="/allproject" class="nav-link link-dark px-2 active" aria-current="page">All creative project</a></li>
                        <li class="nav-item"><a href="/my_donates" class="nav-link link-dark px-2 active" aria-current="page">My Donated projects</a></li>

                    @elseif (auth()->user()->role == 2)   
                        <li class="nav-item"><a href="/project_manager" class="nav-link link-dark px-2 active" aria-current="page">Project</a></li>
                        <li class="nav-item"><a href="/categoriesmanager_show" class="nav-link link-dark px-2 active" aria-current="page">Categories</a></li>
                        <li class="nav-item"><a href="/commentsmanager_show" class="nav-link link-dark px-2 active" aria-current="page">Comments</a></li>
                        <li class="nav-item"><a href="/complaintmanager_show" class="nav-link link-dark px-2 active" aria-current="page">Complaint</a></li>
                        <li class="nav-item"><a href="/complaint_comments" class="nav-link link-dark px-2 active" aria-current="page">Complaint comments</a></li>

                        
                    @endif
                @else
                    <li class="nav-item"><a href="/allproject" class="nav-link link-dark px-2 active" aria-current="page">All creative project</a></li>
                @endif
              </ul>
              <ul class="nav">
                @guest
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link link-dark px-2">{{ __('Login') }}</a></li>
                    @if (Route::has('register'))
                    
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link link-dark px-2">{{ __('Register') }}</a></li>
                    @endif
                @else
                     <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Hello, {{ Auth::user()->name }}</a></li>
                    <li class="nav-item"><a href="/logout" class="nav-link link-dark px-2">({{ __('Logout') }})</a></li>
                @endguest
              </ul>
            </div>
        </nav>
        <header class="py-3 mb-4 border-bottom banner_logo" >
            <div class="container d-flex flex-wrap justify-content-center">
                <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
                   
                    <span class="fs-3">Creative Project </span>
                </a>
                  
            </div>
        </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
   
</body>
</html>
