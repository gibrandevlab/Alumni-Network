@extends('layouts.index')

@section('title', $workshop->judul_event . ' - Detail Workshop')

@section('content')
<div class="container py-8 min-h-screen">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8">
        <div class="mb-6">
            <a href="{{ route('alumni.workshop.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali ke daftar event</a>
        </div>
        <div class="mb-6">
            <img src="{{ $workshop->foto ? asset('storage/'.$workshop->foto) : 'https://via.placeholder.com/600x300' }}" class="w-full h-56 object-cover rounded-xl mb-4" alt="Event Image">
            <h1 class="text-3xl font-bold text-blue-700 mb-2">{{ $workshop->judul_event }}</h1>
            <div class="text-gray-500 mb-2">Diselenggarakan oleh <span class="font-semibold text-gray-800">{{ $workshop->dilaksanakan_oleh }}</span></div>
            <div class="flex flex-wrap gap-4 mb-4 text-sm">
                <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">Tanggal Mulai: <b>{{ $workshop->tanggal_mulai ? \Carbon\Carbon::parse($workshop->tanggal_mulai)->format('d M Y') : '-' }}</b></div>
                <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">Akhir Pendaftaran: <b>{{ $workshop->tanggal_akhir_pendaftaran ? \Carbon\Carbon::parse($workshop->tanggal_akhir_pendaftaran)->format('d M Y') : '-' }}</b></div>
                <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">Maksimal Peserta: <b>{{ $workshop->maksimal_peserta ?: 'Unlimited' }}</b></div>
            </div>
            <div class="mb-4">
                <span class="text-lg font-bold {{ $workshop->harga_daftar > 0 ? 'text-green-600' : 'text-blue-600' }}">
                    {{ $workshop->harga_daftar > 0 ? 'Rp'.number_format($workshop->harga_daftar,0,',','.') : 'Gratis' }}
                </span>
            </div>
            <div class="mb-6 text-gray-700 leading-relaxed">
                {!! nl2br(e($workshop->deskripsi_event)) !!}
            </div>
            @if($workshop->link)
            <a href="{{ $workshop->link }}" target="_blank" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition">Daftar / Info Selengkapnya</a>
            @endif
        </div>
    </div>
</div>
@endsection