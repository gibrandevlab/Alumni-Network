@extends('layouts.Dashboard.dashboard')

@section('title', isset($kuesioner) ? 'Edit Kuesioner' : 'Tambah Kuesioner')

@section('content')
@php $editPertanyaanId = request('edit_pertanyaan'); @endphp
<div class="min-h-screen flex flex-row bg-gradient-to-br from-blue-50 to-blue-100 text-gray-800">
    @include('layouts.Dashboard.sidebarkiri', [], ['class' => 'w-64 flex-shrink-0'])
    <div class="flex-1 flex flex-col items-center justify-center p-8 ml-0 md:ml-64 transition-all duration-300">
        <div class="w-full max-w-2xl">
            <div class="mb-8 animate-fade-in">
                <h1 class="text-4xl font-bold text-blue-700 mb-2">{{ isset($kuesioner) ? 'Edit Kuesioner' : 'Tambah Kuesioner' }}</h1>
            </div>
            <form method="POST" action="{{ isset($kuesioner) ? route('dashboard.kuesioner.update', $kuesioner->id) : route('dashboard.kuesioner.store') }}" class="bg-white rounded-2xl shadow-xl p-8 mb-10 animate-fade-in-up border border-blue-100">
                @csrf
                @if(isset($kuesioner)) @method('PUT') @endif
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-blue-700 mb-1">Judul Kuesioner</label>
                    <input type="text" name="judul" value="{{ old('judul', $kuesioner->judul ?? '') }}" required class="w-full px-4 py-3 border border-blue-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-blue-50/30">
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-blue-700 mb-1">Deskripsi Kuesioner</label>
                    <textarea name="deskripsi" rows="3" required class="w-full px-4 py-3 border border-blue-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-blue-50/30">{{ old('deskripsi', $kuesioner->deskripsi ?? '') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-blue-700 mb-1">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" value="{{ old('tahun_mulai', $kuesioner->tahun_mulai ?? '') }}" required min="2000" max="2100" class="w-full px-4 py-3 border border-blue-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-blue-50/30">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-blue-700 mb-1">Tahun Akhir</label>
                        <input type="number" name="tahun_akhir" value="{{ old('tahun_akhir', $kuesioner->tahun_akhir ?? '') }}" required min="2000" max="2100" class="w-full px-4 py-3 border border-blue-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-blue-50/30">
                    </div>
                </div>
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-blue-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-3 border border-blue-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-blue-50/30">
                        <option value="aktif" @if(old('status', $kuesioner->status ?? '')=='aktif') selected @endif>Aktif</option>
                        <option value="nonaktif" @if(old('status', $kuesioner->status ?? '')=='nonaktif') selected @endif>Nonaktif</option>
                    </select>
                </div>
                <div class="flex gap-4 mt-8">
                    <a href="{{ route('dashboard.kuesioner.index') }}" class="flex-1 px-4 py-3 border border-blue-200 text-blue-700 rounded-xl hover:bg-blue-50 text-center font-semibold transition">Batal</a>
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-3 rounded-xl shadow transition">Simpan</button>
                </div>
            </form>
            @if(isset($kuesioner))
            <div id="pertanyaan" class="mt-12 animate-fade-in-up">
                <h2 class="text-2xl font-bold text-blue-700 mb-6">Kelola Pertanyaan</h2>
                <form method="POST" action="{{ route('dashboard.kuesioner.pertanyaan.add', $kuesioner->id) }}" class="bg-blue-50 rounded-xl p-6 mb-8 flex flex-col md:flex-row gap-4 items-end border border-blue-100">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-blue-700 mb-1">Pertanyaan</label>
                        <input type="text" name="pertanyaan" required class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-700 mb-1">Tipe</label>
                        <select name="tipe" required class="px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="likert">Likert</option>
                            <option value="esai">Esai</option>
                            <option value="pilihan">Pilihan Ganda</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-700 mb-1">Skala/Opsi</label>
                        <input type="text" name="skala" placeholder="1-5 / Opsi1,Opsi2" class="px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-700 mb-1">Urutan</label>
                        <input type="number" name="urutan" min="1" required class="w-20 px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">Tambah</button>
                </form>
                <div class="overflow-x-auto bg-white rounded-xl shadow border border-blue-100">
                    <table class="min-w-full divide-y divide-blue-100">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-blue-700">Pertanyaan</th>
                                <th class="px-4 py-2 text-center text-xs font-semibold text-blue-700">Tipe</th>
                                <th class="px-4 py-2 text-center text-xs font-semibold text-blue-700">Skala/Opsi</th>
                                <th class="px-4 py-2 text-center text-xs font-semibold text-blue-700">Urutan</th>
                                <th class="px-4 py-2 text-center text-xs font-semibold text-blue-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-50">
                            @forelse($kuesioner->pertanyaan as $p)
                            <tr>
                                <td class="px-4 py-2 text-gray-900">{{ $p->pertanyaan }}</td>
                                <td class="px-4 py-2 text-center">{{ ucfirst($p->tipe) }}</td>
                                <td class="px-4 py-2 text-center text-xs text-gray-600">{{ $p->skala }}</td>
                                <td class="px-4 py-2 text-center">{{ $p->urutan }}</td>
                                <td class="px-4 py-2 text-center flex gap-2 justify-center">
                                    <form action="{{ route('dashboard.kuesioner.pertanyaan.delete', [$kuesioner->id, $p->id]) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1 rounded text-xs font-semibold transition">Hapus</button>
                                    </form>
                                    <a href="{{ route('dashboard.kuesioner.edit', [$kuesioner->id, '#pertanyaan', 'edit_pertanyaan' => $p->id]) }}" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs font-semibold transition">Edit</a>
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
            <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-100 animate-fade-in-up">
                <h3 class="font-semibold mb-3 text-blue-800 text-lg">Edit Pertanyaan</h3>
                <form method="POST" action="{{ route('dashboard.kuesioner.pertanyaan.add', $kuesioner->id) }}">
                    @csrf
                    <input type="hidden" name="edit_id" value="{{ $pertanyaanEdit->id }}">
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-blue-700 mb-1">Pertanyaan</label>
                        <input type="text" name="pertanyaan" value="{{ $pertanyaanEdit->pertanyaan }}" required class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-blue-700 mb-1">Tipe</label>
                        <select name="tipe" required class="px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="likert" @if($pertanyaanEdit->tipe=='likert') selected @endif>Likert</option>
                            <option value="esai" @if($pertanyaanEdit->tipe=='esai') selected @endif>Esai</option>
                            <option value="pilihan" @if($pertanyaanEdit->tipe=='pilihan') selected @endif>Pilihan Ganda</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-blue-700 mb-1">Skala/Opsi</label>
                        <input type="text" name="skala" value="{{ $pertanyaanEdit->skala }}" class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-blue-700 mb-1">Urutan</label>
                        <input type="number" name="urutan" value="{{ $pertanyaanEdit->urutan }}" min="1" required class="w-20 px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>
                    <div class="flex gap-3 mt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">Simpan Perubahan</button>
                        <a href="{{ route('dashboard.kuesioner.edit', $kuesioner->id) }}#pertanyaan" class="px-4 py-2 border border-blue-200 text-blue-700 rounded-lg hover:bg-blue-50 transition">Batal</a>
                    </div>
                </form>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out;
    }
</style>
@endsection