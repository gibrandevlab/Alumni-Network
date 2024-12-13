<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Alumni Network</title>

    <meta name="description" content="Aplikasi Sistem Informasi Alumni Network">
    <meta name="keywords" content="Alumni Network">

    <meta property="og:title" content="GOBANA - Toko Tanaman Hias Terbaik untuk Dekorasi dan Hadiah" />
    <meta property="og:description" content="Temukan keindahan tanaman hias segar dari Gobana Flower Boutique untuk dekorasi rumah atau hadiah. Koleksi tanaman segar yang menambah kebahagiaan dan suasana alami." />
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="GOBANA - Toko Tanaman Hias Terbaik untuk Dekorasi dan Hadiah">
    <meta name="twitter:description" content="Temukan koleksi tanaman hias segar untuk dekorasi rumah atau hadiah dari Gobana Flower Boutique.">

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    @vite('resources/css/app.css')
</head>

<body class="font-sans">

    @include('components.welcome.hero')
    @include('layouts.navbar')
    @include('components.welcome.tentang')
    @include('components.welcome.footer')
    <a href="https://wa.me/6285814701149?text=Hello,%20i%20want%20more%20information%20about%20tracer%20study" target="_blank" rel="noopener noreferrer" style="position: fixed; bottom: 1rem; right: 1rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);" class="bg-white text-black p-3 rounded-full z-50 flex items-center hover:bg-gray-200 transition-all duration-200 ease-in-out relative">
    <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" height="24px" width="24px" viewBox="0 0 60 60" class="mr-2 h-6 w-6 sm:h-5 sm:w-5">
        <path d="M54,2H6C2.748,2,0,4.748,0,8v33c0,3.252,2.748,6,6,6h8v10c0,0.413,0.254,0.784,0.64,0.933C14.757,57.978,14.879,58,15,58
        c0.276,0,0.547-0.115,0.74-0.327L25.442,47H54c3.252,0,6-2.748,6-6V8C60,4.748,57.252,2,54,2z M12,15h15c0.553,0,1,0.448,1,1
        s-0.447,1-1,1H12c-0.553,0-1-0.448-1-1S11.447,15,12,15z M46,33H12c-0.553,0-1-0.448-1-1s0.447-1,1-1h34c0.553,0,1,0.448,1,1
        S46.553,33,46,33z M46,25H12c-0.553,0-1-0.448-1-1s0.447-1,1-1h34c0.553,0,1,0.448,1,1S46.553,25,46,25z"/>
    </svg>
    Obrolan
    <!-- Notifikasi Merah -->
    <span class="absolute top-0 right-0 bg-red-500 h-4 w-4 text-white text-xs font-bold rounded-full px-1">1</span>
</a>
</body>

</html>
