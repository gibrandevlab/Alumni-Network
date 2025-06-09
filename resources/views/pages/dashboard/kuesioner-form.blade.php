@extends('layouts.Dashboard.dashboard')

@section('title', isset($kuesioner) ? 'Edit Kuesioner' : 'Tambah Kuesioner')

@section('content')
@php $editPertanyaanId = request('edit_pertanyaan'); @endphp
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">{{ isset($kuesioner) ? 'Edit Kuesioner' : 'Tambah Kuesioner' }}</h1>
        <a href="{{ route('dashboard.kuesioner.index') }}" class="text-amber-600 hover:underline text-sm">&larr; Kembali ke daftar kuesioner</a>
    </div>
    <form method="POST" action="{{ isset($kuesioner) ? route('dashboard.kuesioner.update', $kuesioner->id) : route('dashboard.kuesioner.store') }}" class="bg-white rounded-lg shadow p-6 mb-8">
        @csrf
        @if(isset($kuesioner)) @method('PUT') @endif
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kuesioner</label>
            <input type="text" name="judul" value="{{ old('judul', $kuesioner->judul ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kuesioner</label>
            <textarea name="deskripsi" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">{{ old('deskripsi', $kuesioner->deskripsi ?? '') }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                <input type="number" name="tahun_mulai" value="{{ old('tahun_mulai', $kuesioner->tahun_mulai ?? '') }}" required min="2000" max="2100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Akhir</label>
                <input type="number" name="tahun_akhir" value="{{ old('tahun_akhir', $kuesioner->tahun_akhir ?? '') }}" required min="2000" max="2100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                <option value="aktif" @if(old('status', $kuesioner->status ?? '')=='aktif') selected @endif>Aktif</option>
                <option value="nonaktif" @if(old('status', $kuesioner->status ?? '')=='nonaktif') selected @endif>Nonaktif</option>
            </select>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-4 py-2 rounded-lg shadow">Simpan</button>
            <a href="{{ route('dashboard.kuesioner.index') }}" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-center">Batal</a>
        </div>
    </form>

    @if(isset($kuesioner))
    <div id="pertanyaan" class="mt-12">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Kelola Pertanyaan</h2>
        <form method="POST" action="{{ route('dashboard.kuesioner.pertanyaan.add', $kuesioner->id) }}" class="bg-gray-50 rounded-lg p-4 mb-6 flex flex-col md:flex-row gap-3 items-end">
            @csrf
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-700 mb-1">Pertanyaan</label>
                <input type="text" name="pertanyaan" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Tipe</label>
                <select name="tipe" required class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                    <option value="likert">Likert</option>
                    <option value="esai">Esai</option>
                    <option value="pilihan">Pilihan Ganda</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Skala/Opsi</label>
                <input type="text" name="skala" placeholder="1-5 / Opsi1,Opsi2" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Urutan</label>
                <input type="number" name="urutan" min="1" required class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg">Tambah</button>
        </form>
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Pertanyaan</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-gray-600">Tipe</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-gray-600">Skala/Opsi</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-gray-600">Urutan</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kuesioner->pertanyaan as $p)
                    <tr>
                        <td class="px-4 py-2 text-gray-900">{{ $p->pertanyaan }}</td>
                        <td class="px-4 py-2 text-center">{{ ucfirst($p->tipe) }}</td>
                        <td class="px-4 py-2 text-center text-xs text-gray-600">{{ $p->skala }}</td>
                        <td class="px-4 py-2 text-center">{{ $p->urutan }}</td>
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('dashboard.kuesioner.pertanyaan.delete', [$kuesioner->id, $p->id]) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1 rounded text-xs font-semibold">Hapus</button>
                            </form>
                            <a href="{{ route('dashboard.kuesioner.edit', [$kuesioner->id, '#pertanyaan', 'edit_pertanyaan' => $p->id]) }}" class="ml-2 bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs font-semibold">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada pertanyaan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($editPertanyaanId)
    @php $pertanyaanEdit = $kuesioner->pertanyaan->where('id', $editPertanyaanId)->first(); @endphp
    @if($pertanyaanEdit)
    <div class="mt-6 bg-blue-50 rounded-lg p-4">
        <h3 class="font-semibold mb-2 text-blue-800">Edit Pertanyaan</h3>
        <form method="POST" action="{{ route('dashboard.kuesioner.pertanyaan.add', $kuesioner->id) }}">
            @csrf
            <input type="hidden" name="edit_id" value="{{ $pertanyaanEdit->id }}">
            <div class="mb-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">Pertanyaan</label>
                <input type="text" name="pertanyaan" value="{{ $pertanyaanEdit->pertanyaan }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            </div>
            <div class="mb-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">Tipe</label>
                <select name="tipe" required class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                    <option value="likert" @if($pertanyaanEdit->tipe=='likert') selected @endif>Likert</option>
                    <option value="esai" @if($pertanyaanEdit->tipe=='esai') selected @endif>Esai</option>
                    <option value="pilihan" @if($pertanyaanEdit->tipe=='pilihan') selected @endif>Pilihan Ganda</option>
                </select>
            </div>
            <div class="mb-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">Skala/Opsi</label>
                <input type="text" name="skala" value="{{ $pertanyaanEdit->skala }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            </div>
            <div class="mb-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">Urutan</label>
                <input type="number" name="urutan" value="{{ $pertanyaanEdit->urutan }}" min="1" required class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            </div>
            <div class="flex gap-2 mt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg">Simpan Perubahan</button>
                <a href="{{ route('dashboard.kuesioner.edit', $kuesioner->id) }}#pertanyaan" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Batal</a>
            </div>
        </form>
    </div>
    @endif
    @endif
</div>
@endsection 