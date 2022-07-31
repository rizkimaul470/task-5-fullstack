<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>@yield('title')</title>
    </head>
    @yield('main')
     <!-- Scripts -->
     <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('javascript')
</html>