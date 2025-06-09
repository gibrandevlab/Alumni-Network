@extends('layouts.Dashboard.dashboard')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Manajemen Kuesioner - ALUMNET')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Kuesioner</h1>
            <p class="text-gray-500 text-sm">Kelola dan monitor kuesioner alumni</p>
        </div>
        <a href="{{ route('dashboard.kuesioner.create') }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition">+ Tambah Kuesioner</a>
                    </div>
    <form method="GET" class="flex flex-col md:flex-row gap-3 mb-6">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kuesioner..." class="w-full md:w-64 px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
        <select name="status" class="w-full md:w-48 px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                    <option value="">Semua Status</option>
            <option value="aktif" @if(request('status')=='aktif') selected @endif>Aktif</option>
            <option value="nonaktif" @if(request('status')=='nonaktif') selected @endif>Nonaktif</option>
                </select>
        <button class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900">Filter</button>
    </form>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Judul</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Deskripsi</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Tahun</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600"># Pertanyaan</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600"># Respon</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kuesioners as $kuesioner)
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $kuesioner->judul }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ Str::limit($kuesioner->deskripsi, 60) }}</td>
                    <td class="px-4 py-3 text-center">{{ $kuesioner->tahun_mulai }} - {{ $kuesioner->tahun_akhir }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $kuesioner->status=='aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                            {{ ucfirst($kuesioner->status) }}
                            </span>
                    </td>
                    <td class="px-4 py-3 text-center">{{ $kuesioner->pertanyaan_count }}</td>
                    <td class="px-4 py-3 text-center">{{ $kuesioner->respon_count }}</td>
                    <td class="px-4 py-3 text-center flex flex-col md:flex-row gap-2 justify-center">
                        <a href="{{ route('dashboard.kuesioner.edit', $kuesioner->id) }}" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs font-semibold">Edit</a>
                        <form action="{{ route('dashboard.kuesioner.destroy', $kuesioner->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kuesioner ini?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1 rounded text-xs font-semibold">Hapus</button>
                    </form>
                        <a href="{{ route('dashboard.kuesioner.edit', $kuesioner->id) }}#pertanyaan" class="bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-1 rounded text-xs font-semibold">Kelola Pertanyaan</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada kuesioner.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection