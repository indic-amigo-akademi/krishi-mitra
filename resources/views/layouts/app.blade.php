<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('partials.seo')

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <script src="{{ mix('/js/vanilla.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet"> 

    

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    @yield('styles')
</head>

<body>

    <header>
        @include('partials.header')
    </header>

    <main class="py-4">
        @yield('content')
    </main>

    <footer>
        @include('partials.footer')
    </footer>

    @yield('scripts')

</body>

</html>