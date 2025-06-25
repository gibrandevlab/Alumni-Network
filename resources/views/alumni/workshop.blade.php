@extends('layouts.index')

@section('title', 'Event & Workshop Alumni - ALUMNET')

@section('content')
<div class="container py-10 min-h-screen mx-auto lg:ml-16">
    <h1 class="text-4xl font-extrabold text-blue-800 mb-10 tracking-tight">Event & Workshop Alumni</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($workshops as $workshop)
        <a href="{{ route('alumni.workshop.show', $workshop->id) }}" class="group block bg-white rounded-2xl shadow-xl flex flex-col overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 hover:border-blue-400">
            <div class="relative">
                <img src="{{ ($workshop->foto && file_exists(public_path('images/events/' . $workshop->foto))) ? asset('images/events/' . $workshop->foto) : 'https://via.placeholder.com/400x200' }}" class="w-full h-52 object-cover transition-transform duration-300 group-hover:scale-105" alt="Event Image">
                <span class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold {{ $workshop->harga_daftar > 0 ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ $workshop->harga_daftar > 0 ? 'Berbayar' : 'Gratis' }}
                </span>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex-1">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors">{{ $workshop->judul_event }}</h2>
                    <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 01-8 0"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                            <path d="M6 21v-2a4 4 0 014-4h0a4 4 0 014 4v2"></path>
                        </svg>
                        {{ $workshop->dilaksanakan_oleh }}
                    </div>
                    <div class="text-xs text-gray-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $workshop->tanggal_mulai ? \Carbon\Carbon::parse($workshop->tanggal_mulai)->format('d M Y') : '-' }} - {{ $workshop->tanggal_akhir_pendaftaran ? \Carbon\Carbon::parse($workshop->tanggal_akhir_pendaftaran)->format('d M Y') : '-' }}
                    </div>
                    <div class="text-gray-700 text-base mb-4">{{ \Illuminate\Support\Str::limit($workshop->deskripsi_event, 90) }}</div>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <div class="flex flex-col">
                        @if(isset($workshop->harga_diskon) && $workshop->harga_diskon > 0)
                        <span class="text-gray-400 line-through text-base">
                            Rp{{ number_format($workshop->harga_diskon,0,',','.') }}
                        </span>
                        <span class="text-lg font-bold text-blue-700">
                            Rp{{ number_format($workshop->harga_daftar,0,',','.') }}
                        </span>
                        @else
                        <span class="text-lg font-bold {{ $workshop->harga_daftar > 0 ? 'text-green-600' : 'text-blue-600' }}">
                            {{ $workshop->harga_daftar > 0 ? 'Rp'.number_format($workshop->harga_daftar,0,',','.') : 'Gratis' }}
                        </span>
                        @endif
                    </div>
                    @if($workshop->link)
                    <span class="px-5 py-2 bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-lg text-sm font-semibold shadow hover:from-blue-700 hover:to-blue-500 transition-all">Daftar</span>
                    @endif
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-3 text-center text-gray-500 py-20">
            <svg class="mx-auto mb-4 w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-xl font-semibold">Belum ada event atau workshop aktif.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection