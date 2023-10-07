<!DOCTYPE html>
<html lang="es-MX" dir="ltr" :class="{'theme-dark': dark}" x-data="data()">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>@yield('title')</title>
        <link rel="shortcut icon" href="{{asset('img/icons/psicologos-guardia.ico')}}" type="image/x-icon" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @yield('body')
    </body>
</html>