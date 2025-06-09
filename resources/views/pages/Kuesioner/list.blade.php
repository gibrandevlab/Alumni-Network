@extends('layouts.index')
@section('title', 'Pengisian Kuesioner Alumni')
@php use Illuminate\Support\Str; @endphp
@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Pengisian Kuesioner Alumni</h1>
    <p class="text-gray-600 mb-6">Silakan pilih kuesioner yang ingin Anda isi.</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($kuesioners as $kuesioner)
        <div class="bg-white rounded-lg shadow p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-1">{{ $kuesioner->judul }}</h2>
                <p class="text-gray-600 text-sm mb-2">{{ Str::limit($kuesioner->deskripsi, 80) }}</p>
                <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                    <span class="bg-gray-100 px-2 py-1 rounded">{{ $kuesioner->tahun_mulai }} - {{ $kuesioner->tahun_akhir }}</span>
                </div>
            </div>
            <a href="{{ route('kuesioner.form', $kuesioner->id) }}" class="mt-4 inline-block bg-amber-500 hover:bg-amber-600 text-white font-semibold px-4 py-2 rounded-lg text-center transition">Isi Kuesioner</a>
        </div>
        @empty
        <div class="col-span-2 text-center text-gray-400 py-12">
            Tidak ada kuesioner aktif saat ini.
        </div>
        @endforelse
    </div>
</div>
@endsection 