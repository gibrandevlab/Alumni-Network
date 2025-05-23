<style>
    html {
        overflow-x: hidden;
    }
</style>

@extends('layouts.index')
<title>@yield('title', 'ALUMNET - Alumni Network')</title>
@include('components.welcome.hero')
@section('content')
    <div class="flex flex-col gap-12 mx-auto md:mx-6 lg:mx-12 xl:mx-18 2xl:mx-24">
        @include('components.welcome.tentang')
        @include('components.welcome.panduan')
        @include('components.welcome.floatchat')
        @include('components.welcome.berita')
    </div>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function () {
    const smoothScrollLinks = document.querySelectorAll("a[href^='#']");
    smoothScrollLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const targetId = this.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: "smooth"
                });
            }
        });
    });
});
</script>

