<!-- filepath: c:\Users\afwan\Alumni-Network\resources\views\layouts\Layout_groupchat.blade.php -->
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Komunitas Alumnet')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'blue-gradient-start': '#0073E6',
                        'blue-gradient-end': '#66B2FF',
                    },
                },
            },
        };
    </script>
    <style>
        .mention-dropdown {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .mention-dropdown div {
            padding: 8px 12px;
            cursor: pointer;
        }
        .mention-dropdown div:hover {
            background-color: #f0f0f0;
        }
        .mention {
            color: #0073E6;
            font-weight: bold;
            background-color: #E6F7FF;
            padding: 2px 4px;
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gradient-to-b from-blue-gradient-start to-blue-gradient-end text-black h-screen flex flex-col">
    @yield('content')
    @stack('scripts')
    @push('scripts')
    <script src="{{ asset('resources/js/groupchat.js') }}"></script>
    @endpush
</body>
</html>
