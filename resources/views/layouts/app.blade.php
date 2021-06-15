<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('layouts.theme.styles')

</head>
<body class="auth-fluid-pages pb-0">
    <div class="auth-fluid">
        @yield('content')
    </div>


    @include('layouts.theme.scripts')

</body>
</html>
