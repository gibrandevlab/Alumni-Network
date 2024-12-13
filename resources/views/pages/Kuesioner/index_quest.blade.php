@extends('layouts.Kuesioner.index')
@section('title', 'Home - SITRA BSI')
@include('components.Kuesioner.hero')

@section('content')
<div id="pilih-tipe-responden" class="container mx-auto px-4  mt-12 mb-12">
    <div class="flex items-center justify-center">
        <h1 class="text-3xl font-bold text-[#003194] leading-tight truncate">Responden Alumni Network</h1>
    </div>
    <div class="flex items-center justify-center">
        <h2 class="text-xl text-gray-600 mb-8 leading-tight truncate">Tautan Kuesioner</h2>
    </div>

    <div class="flex flex-wrap justify-center gap-8">

        <!-- Card pertama -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col w-full md:w-1/3 min-h-[350px]"
            style="max-width: 350px; border-bottom: 4px solid blue;">
            <img class="w-full h-48 object-cover" src="{{ asset('images/pengisian5.jpg') }}"
                alt="Image 2">
            <div class="p-4 flex flex-col flex-grow">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Alumni Network 1</h3>
                <p class="text-gray-600 text-base mb-4">Pengisian kuesioner dilaksanakan 1 tahun setelah kelulusan.</p>
                <div class="px-4 py-2 mt-auto">
                    <a href="/pengisian-tracer-study/Tracer-Study-1" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 min-w-[220px]">
                        Isi Kuesioner
                    </a>
                </div>
            </div>
        </div>

        <!-- Card kedua -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col w-full md:w-1/3 min-h-[350px]"
            style="max-width: 350px; border-bottom: 4px solid blue;">
            <img class="w-full h-48 object-cover"
                src="{{ asset('images/pengisian6.jpg') }}" alt="Image 3">
            <div class="p-4 flex flex-col flex-grow">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Survey Kepuasan Pengguna Lulusan</h3>
                <p class="text-gray-600 text-base mb-4">Pengisian kuesioner dilaksanakan oleh perusahaan mitra tempat lulusan bekerja.</p>
                <div class="px-4 py-2 mt-auto">
                    <a href="/pengisian-tracer-study/Tracer-Study-2" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 min-w-[220px]">
                        Isi Kuesioner
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const smoothScrollLinks = document.querySelectorAll("a[href^='#']");
        smoothScrollLinks.forEach(link => {
            link.addEventListener("click", function(e) {
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
