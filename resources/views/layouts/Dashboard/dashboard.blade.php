
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    @vite('resources/css/app.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
<main>
    @yield('content')
</main>
</body>
