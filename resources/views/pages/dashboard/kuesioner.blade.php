@extends('layouts.Dashboard.dashboard')

@section('title', 'Manage Kuesioner - ALUMNET')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="min-h-screen flex flex-row bg-gradient-to-br from-blue-50 to-blue-100 text-gray-800">
    @include('layouts.Dashboard.sidebarkiri', [], ['class' => 'w-64 flex-shrink-0'])
    <div class="flex-1 p-8 ml-0 md:ml-64 transition-all duration-300">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-4xl font-bold text-blue-700 mb-2">
                Manajemen Kuesioner
            </h1>
            <p class="text-gray-600">Kelola dan monitor kuesioner alumni</p>
        </div>
        <div class="mb-8 animate-fade-in-up">
            <button onclick="openKuesionerForm()" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center space-x-3">
                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Tambah Kuesioner Baru</span>
            </button>
        </div>
        <!-- Modal Form Tambah Kuesioner -->
        <div id="kuesionerModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300">
            <div id="kuesionerModalContent" class="bg-white rounded-2xl shadow-2xl w-full max-w-xl mx-4 relative transform scale-95 transition-transform duration-300">
                <div class="bg-blue-600 text-white p-6 rounded-t-2xl flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Tambah Kuesioner</h2>
                    <button onclick="closeKuesionerForm()" class="text-white hover:text-red-300 transition-colors duration-200 p-2 hover:bg-white hover:bg-opacity-20 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-8 max-h-[80vh] overflow-y-auto">
                    <form id="formTambahKuesioner" method="POST" action="{{ route('dashboard.kuesioner.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kuesioner</label>
                            <input type="text" name="judul" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kuesioner</label>
                            <textarea name="deskripsi" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                                <input type="number" name="tahun_mulai" required min="2000" max="2100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Akhir</label>
                                <input type="number" name="tahun_akhir" required min="2000" max="2100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button type="submit" id="kuesionerSubmitBtn" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2">
                                Simpan
                            </button>
                            <button type="button" onclick="closeKuesionerForm()" class="flex-1 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-center px-6 py-3 rounded-xl font-semibold flex items-center justify-center space-x-2">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <form method="GET" class="flex flex-col md:flex-row gap-3 mb-6">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kuesioner..." class="w-full md:w-64 px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            <select name="status" class="w-full md:w-48 px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                <option value="">Semua Status</option>
                <option value="aktif" @if(request('status')=='aktif' ) selected @endif>Aktif</option>
                <option value="nonaktif" @if(request('status')=='nonaktif' ) selected @endif>Nonaktif</option>
            </select>
            <button class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900">Filter</button>
        </form>
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up">
            <div class="bg-blue-600 text-white p-6">
                <h2 class="text-2xl font-bold flex items-center space-x-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Daftar Kuesioner</span>
                </h2>
            </div>
            <div class="overflow-x-auto">
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
                                <a href="{{ route('dashboard.kuesioner.edit', $kuesioner->id) }}#pertanyaan" class="bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-1 rounded text-xs font-semibold">Kelola Pertanyaan</a>
                                <form action="{{ route('dashboard.kuesioner.destroy', $kuesioner->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kuesioner ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1 rounded text-xs font-semibold">Hapus</button>
                                </form>                                
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h3m4 4v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6a2 2 0 012-2h.01"></path>
                                    </svg>
                                    Belum ada kuesioner.<br><span class="text-sm">Mulai dengan menambah kuesioner baru</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
<script>
    function openKuesionerForm() {
        const modal = document.getElementById('kuesionerModal');
        const content = document.getElementById('kuesionerModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeKuesionerForm() {
        const modal = document.getElementById('kuesionerModal');
        const content = document.getElementById('kuesionerModalContent');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('formTambahKuesioner').addEventListener('submit', function() {
            const submitBtn = document.getElementById('kuesionerSubmitBtn');
            submitBtn.innerHTML = `<svg class='animate-spin w-5 h-5 mr-2' fill='none' viewBox='0 0 24 24'><circle class='opacity-25' cx='12' cy='12' r='10' stroke='currentColor' stroke-width='4'></circle><path class='opacity-75' fill='currentColor' d='M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z'></path></svg> Menyimpan...`;
            submitBtn.disabled = true;
        });
        document.getElementById('kuesionerModal').addEventListener('click', function(e) {
            if (e.target === this) closeKuesionerForm();
        });
    });
</script>
@endsection