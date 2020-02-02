<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/sb-admin-2.css') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
     <link
     href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
     rel="stylesheet"
     integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
     crossorigin="anonymous"
   />

</head>
<body id="page-top">
    {{-- for guest or unauthenticate users --}}
    @guest
        <div id="app">
            {{-- include navbar --}}
            @include('include.navbar')
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    @endguest

    {{-- for authenticate users --}}
    @auth
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'organizer')

            <div id="app">
                @yield('content')
            </div>
            
        @else
            {{-- authenticate with role: user --}}
            <div id="app">
                {{-- include navbar --}}
                @include('include.navbar')
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        @endif
    @endauth

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('template/sb-admin-2.js')}}"></script>
    @yield('scripts')
</body>
</html>
