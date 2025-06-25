<?php
@extends('layouts.Dashboard.dashboard')

@section('title', 'Detail Kuesioner - ALUMNET')

@section('content')
<div class="min-h-screen flex flex-row bg-gradient-to-br from-blue-50 to-blue-100 text-gray-800">
    @include('layouts.Dashboard.sidebarkiri', [], ['class' => 'w-64 flex-shrink-0'])
    <div class="flex-1 p-8 ml-0 md:ml-64 transition-all duration-300">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-blue-700 mb-2">
                Detail Kuesioner
            </h1>
            <p class="text-gray-600">Informasi lengkap kuesioner alumni</p>
        </div>
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-2xl mx-auto animate-fade-in-up">
            <dl class="divide-y divide-gray-200">
                <div class="py-4 flex justify-between">
                    <dt class="font-semibold text-gray-700">Judul</dt>
                    <dd class="text-gray-900">{{ $kuesioner->judul }}</dd>
                </div>
                <div class="py-4 flex justify-between">
                    <dt class="font-semibold text-gray-700">Deskripsi</dt>
                    <dd class="text-gray-900 text-right">{{ $kuesioner->deskripsi }}</dd>
                </div>
                <div class="py-4 flex justify-between">
                    <dt class="font-semibold text-gray-700">Tahun</dt>
                    <dd class="text-gray-900">{{ $kuesioner->tahun_mulai }} - {{ $kuesioner->tahun_akhir }}</dd>
                </div>
                <div class="py-4 flex justify-between">
                    <dt class="font-semibold text-gray-700">Status</dt>
                    <dd>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $kuesioner->status=='aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                            {{ ucfirst($kuesioner->status) }}
                        </span>
                    </dd>
                </div>
                <div class="py-4 flex justify-between">
                    <dt class="font-semibold text-gray-700">Jumlah Pertanyaan</dt>
                    <dd class="text-gray-900">{{ $kuesioner->pertanyaan_count }}</dd>
                </div>
                <div class="py-4 flex justify-between">
                    <dt class="font-semibold text-gray-700">Jumlah Respon</dt>
                    <dd class="text-gray-900">{{ $kuesioner->respon_count }}</dd>
                </div>
            </dl>
            <div class="mt-8 flex gap-3">
                <a href="{{ route('dashboard.kuesioner.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold transition">Kembali</a>
                <a href="{{ route('dashboard.kuesioner.edit', $kuesioner->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-lg font-semibold transition">Edit Pertanyaan</a>
            </div>
        </div>
    </div>
</div>
@endsection