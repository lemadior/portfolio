<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        <title>@yield('title', 'FauxEd: University Students Database')</title>
    </head>

    <body>
        <div class="mywrapper">
            @include('includes.header')
            @include('includes.errors')

            @yield('content')

            <link rel="stylesheet" href="{{ asset('assets/js/bootstrap.min.js') }}">
            @include('includes.footer')
        </div>
    </body>

</html>
