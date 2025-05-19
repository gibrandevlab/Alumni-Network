<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAFAFA;
            color: #1F2937;
        }

        .card {
            background-color: #FFFFFF;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 16px;
        }

        .btn-primary {
            background-color: #F59E0B;
            color: #FFFFFF;
            border-radius: 4px;
            padding: 8px 16px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #D97706;
        }

        .btn-secondary {
            background-color: #10B981;
            color: #FFFFFF;
            border-radius: 4px;
            padding: 8px 16px;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #059669;
        }
    </style>
</head>

<body>
    <main>
        @yield('content')
    </main>
</body>

</html>
