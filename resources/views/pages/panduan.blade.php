<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan - SITRA BSK</title>
    <!-- Menggunakan Tailwind CSS dari CDN -->
    @vite('resources/css/app.css')
    <style>
        /* Menyesuaikan gaya iframe agar tampilan full tanpa scroll atau margin */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <iframe
        src="{{ asset('storage/pdfs/Panduan_tracer_Study.pdf') }}"
        class="w-full h-full border-0">
    </iframe>
</body>
</html>

