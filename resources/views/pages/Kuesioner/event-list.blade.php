@extends('layouts.index')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-white to-blue-50">
    <!-- Header Section -->
    <div class="bg-blue-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Event Kuesioner</h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    Berpartisipasilah dalam berbagai survei dan kuesioner untuk membantu meningkatkan kualitas layanan kami
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white border-b border-blue-100">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-800">{{ count($events) }}</h3>
                    <p class="text-blue-600">Kuesioner Tersedia</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-800">1000+</h3>
                    <p class="text-blue-600">Partisipan Aktif</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-800">95%</h3>
                    <p class="text-blue-600">Tingkat Kepuasan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Grid Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-blue-800 mb-4">Pilih Event Kuesioner</h2>
            <p class="text-lg text-blue-600 max-w-2xl mx-auto">
                Temukan berbagai event kuesioner yang tersedia dan berikan kontribusi Anda untuk penelitian dan pengembangan
            </p>
        </div>

        @if(count($events) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-blue-100">
                    @php
                        $canFill = ($role === 'alumni' && $status === 'approved') || ($role === 'admin' && $status === 'approved');
                        $isAlumniNotApproved = ($role === 'alumni' && $status !== 'approved');
                    @endphp
                    @if($canFill)
                        <a href="{{ route('kuesioner.form', ['event_id' => $event->id]) }}" class="block focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @else
                        <a href="#" onclick="event.preventDefault(); @if($isAlumniNotApproved) alert('Akun alumni Anda belum disetujui. Anda belum dapat mengisi kuesioner.'); @else alert('Anda tidak memiliki akses mengisi kuesioner.'); @endif" class="block cursor-not-allowed opacity-60">
                    @endif
                        <!-- Image Container -->
                        <div class="relative overflow-hidden">
                            <img src="{{ $event->foto ?? '/images/defaultkuesioner.png' }}"
                                 class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 alt="Event Foto">
                            <div class="absolute top-4 right-4">
                                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $event->tahun_mulai }} - {{ $event->tahun_akhir }}
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex flex-col h-full">
                            <div class="flex-grow">
                                <h3 class="font-bold text-xl text-blue-800 mb-3 group-hover:text-blue-600 transition-colors">
                                    {{ $event->judul_event }}
                                </h3>
                                <p class="text-blue-600 mb-4 line-clamp-3">
                                    {{ $event->deskripsi_event }}
                                </p>
                            </div>

                            <!-- Event Details -->
                            <div class="border-t border-blue-100 pt-4 mb-6">
                                <div class="flex items-center text-sm text-blue-500 mb-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Periode: {{ $event->tahun_mulai }} - {{ $event->tahun_akhir }}
                                </div>
                                <div class="flex items-center text-sm text-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Status: Aktif
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <span class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 text-center inline-block group-hover:shadow-lg transform group-hover:-translate-y-0.5">
                                <span class="flex items-center justify-center">
                                    Isi Kuesioner
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                            </span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-blue-800 mb-4">Belum Ada Event Tersedia</h3>
                <p class="text-blue-600 max-w-md mx-auto">
                    Saat ini belum ada event kuesioner yang tersedia. Silakan kembali lagi nanti untuk melihat event terbaru.
                </p>
            </div>
        @endif
    </div>

    <!-- Call to Action Section -->
    <div class="bg-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ingin Tahu Lebih Lanjut?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Hubungi tim kami untuk informasi lebih lanjut tentang program kuesioner dan cara berpartisipasi
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-8 rounded-xl transition-colors">
                    Hubungi Kami
                </a>
                <a href="#" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-semibold py-3 px-8 rounded-xl transition-colors">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
