<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GOBANA</title>
    @vite('resources/css/app.css')
    @vite('resources/css/about.css')
</head>

<body class="bg-secondary">
    @include('layouts.navbar')

    @include('components.about.about-section')
    @include('components.about.feature-section')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fadeInElements = document.querySelectorAll('.about-animation');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            });

            fadeInElements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
</body>

</html>
