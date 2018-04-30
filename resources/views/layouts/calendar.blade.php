<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('public/calendar/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/calendar/css/font-awesome.min.css') }}">

    <script src="{{ asset('public/calendar/js/jquery.min.js') }}"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet"> 
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVc15TlZeXKL9l2le5J4n8T8RXmqskBlM&libraries=places"></script>
    
    <link rel="stylesheet" href="{{ asset('public/calendar/css/custom.css') }}">
    
    <script src="{{ asset('public/calendar/js/bootstrap.min.js') }}"></script>

    <link href="{{asset('public/calendar/css/fullcalendar.min.css')}}" rel='stylesheet' />

    <link href="{{asset('public/calendar/css/fullcalendar.print.min.css')}}" rel='stylesheet'  media='print' />
    
    <script src="{{asset('public/calendar/js/moment.min.js')}}"></script>
    
    <script src="{{asset('public/calendar/js/fullcalendar.min.js')}}"></script>

    <script src="{{asset('public/calendar/js/theme-chooser.js')}}"></script>

    <script src="{{asset('public/calendar/js/custom.js')}}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown" id="dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
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
