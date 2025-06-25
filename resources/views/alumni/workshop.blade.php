@extends('layouts.index')

@section('title', 'Event & Workshop Alumni - ALUMNET')

@section('content')
<div class="container py-8 min-h-screen">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">Daftar Event & Workshop</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($workshops as $workshop)
        <a href="{{ route('alumni.workshop.show', $workshop->id) }}" class="block bg-white rounded-xl shadow-lg flex flex-col overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-200">
            <img src="{{ ($workshop->foto && file_exists(public_path('images/events/' . $workshop->foto))) ? asset('images/events/' . $workshop->foto) : 'https://via.placeholder.com/400x200' }}" class="w-full h-48 object-cover" alt="Event Image">
            <div class="p-5 flex-1 flex flex-col">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-800 mb-1">{{ $workshop->judul_event }}</h2>
                    <div class="text-sm text-gray-500 mb-2">{{ $workshop->dilaksanakan_oleh }}</div>
                    <div class="text-xs text-gray-400 mb-2">{{ $workshop->tanggal_mulai ? \Carbon\Carbon::parse($workshop->tanggal_mulai)->format('d M Y') : '-' }} - {{ $workshop->tanggal_akhir_pendaftaran ? \Carbon\Carbon::parse($workshop->tanggal_akhir_pendaftaran)->format('d M Y') : '-' }}</div>
                    <div class="text-gray-700 text-sm mb-3">{{ \Illuminate\Support\Str::limit($workshop->deskripsi_event, 100) }}</div>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-base font-bold {{ $workshop->harga_daftar > 0 ? 'text-green-600' : 'text-blue-600' }}">
                        {{ $workshop->harga_daftar > 0 ? 'Rp'.number_format($workshop->harga_daftar,0,',','.') : 'Gratis' }}
                    </span>
                    @if($workshop->link)
                    <span class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold">Daftar</span>
                    @endif
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-3 text-center text-gray-500 py-16">
            <svg class="mx-auto mb-4 w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-lg font-semibold">Belum ada event atau workshop aktif.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection