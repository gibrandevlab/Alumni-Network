@extends('layouts.Dashboard.dashboard')

@section('title', isset($kuesioner) ? 'Edit Kuesioner' : 'Tambah Kuesioner')

@section('content')
<div class="min-h-screen flex flex-row bg-gradient-to-br from-blue-50 to-blue-100 text-gray-800">
    @include('layouts.Dashboard.sidebarkiri', [], ['class' => 'w-64 flex-shrink-0'])
    <div class="flex-1 p-8 ml-0 md:ml-64 transition-all duration-300">
        <div class="w-full">
            <div class="mb-8 animate-fade-in">
                <a href="{{ route('dashboard.kuesioner.index') }}" class="text-blue-600 hover:underline"> &larr; Kembali</a>
                <h1 class="text-4xl font-bold text-blue-700 mb-2">{{ isset($kuesioner) ? 'Edit Kuesioner' : 'Tambah Kuesioner' }}</h1>
            </div>

            <!-- Form Kuesioner Utama -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-10 animate-fade-in-up border border-blue-100 max-w-2xl mx-auto">
                <form method="POST" action="{{ isset($kuesioner) ? route('dashboard.kuesioner.update', $kuesioner->id) : route('dashboard.kuesioner.store') }}">
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
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-3 rounded-xl shadow transition">Simpan</button>
                        <a href="{{ route('dashboard.kuesioner.index') }}" class="flex-1 px-4 py-3 border border-blue-200 text-blue-700 rounded-xl hover:bg-blue-50 text-center font-semibold transition">Batal</a>
                    </div>
                </form>
            </div>

            @if(isset($kuesioner))
            <!-- Section Kelola Pertanyaan -->
            <div id="pertanyaan" class="mt-12 animate-fade-in-up">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-blue-700">Kelola Pertanyaan</h2>
                    <button onclick="toggleAddForm()" id="toggleAddBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                        <span id="toggleAddText">+ Tambah Pertanyaan</span>
                    </button>
                </div>

                <!-- Form Tambah Pertanyaan (Hidden by default) -->
                <div id="addQuestionForm" class="bg-blue-50 rounded-xl p-6 mb-8 border border-blue-100 max-w-5xl mx-auto hidden">
                    <h3 class="font-semibold mb-4 text-blue-800">Tambah Pertanyaan Baru</h3>
                    <form method="POST" action="{{ route('dashboard.kuesioner.pertanyaan.add', $kuesioner->id) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-semibold text-blue-700 mb-1">Pertanyaan</label>
                                <input type="text" name="pertanyaan" required class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-blue-700 mb-1">Tipe</label>
                                <select name="tipe" required class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                                    <option value="likert">Likert</option>
                                    <option value="esai">Esai</option>
                                    <option value="pilihan">Pilihan Ganda</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-blue-700 mb-1">Skala/Opsi</label>
                                <input type="text" name="skala" placeholder="1-5 / Opsi1,Opsi2" class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">Tambah</button>
                            <button type="button" onclick="toggleAddForm()" class="px-4 py-2 border border-blue-200 text-blue-700 rounded-lg hover:bg-blue-50 transition">Batal</button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Pertanyaan -->
                <div class="overflow-x-auto bg-white rounded-2xl shadow border border-blue-100 max-w-5xl mx-auto">
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
                                <td class="px-4 py-2 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <button onclick="openEditModal({{ $p->id }}, '{{ $p->pertanyaan }}', '{{ $p->tipe }}', '{{ $p->skala }}', {{ $p->urutan }})"
                                                class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs font-semibold transition">
                                            Edit
                                        </button>
                                        <form action="{{ route('dashboard.kuesioner.pertanyaan.delete', [$kuesioner->id, $p->id]) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1 rounded text-xs font-semibold transition">Hapus</button>
                                        </form>
                                    </div>
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
        </div>
    </div>
</div>

<!-- Modal Edit Pertanyaan -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 animate-fade-in-up">
        <h3 class="font-semibold mb-4 text-blue-800 text-lg">Edit Pertanyaan</h3>
        <form method="POST" action="{{ isset($kuesioner) ? route('dashboard.kuesioner.pertanyaan.add', $kuesioner->id) : '#' }}" id="editForm">
            @csrf
            <input type="hidden" name="edit_id" id="editId">

            <div class="mb-3">
                <label class="block text-xs font-semibold text-blue-700 mb-1">Pertanyaan</label>
                <input type="text" name="pertanyaan" id="editPertanyaan" required class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-blue-700 mb-1">Tipe</label>
                <select name="tipe" id="editTipe" required class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="likert">Likert</option>
                    <option value="esai">Esai</option>
                    <option value="pilihan">Pilihan Ganda</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-blue-700 mb-1">Skala/Opsi</label>
                <input type="text" name="skala" id="editSkala" class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-blue-700 mb-1">Urutan</label>
                <input type="number" name="urutan" id="editUrutan" min="1" required class="w-20 px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">Simpan Perubahan</button>
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-blue-200 text-blue-700 rounded-lg hover:bg-blue-50 transition">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle form tambah pertanyaan
function toggleAddForm() {
    const form = document.getElementById('addQuestionForm');
    const btn = document.getElementById('toggleAddBtn');
    const text = document.getElementById('toggleAddText');

    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        text.textContent = '- Tutup Form';
        btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        btn.classList.add('bg-red-600', 'hover:bg-red-700');
    } else {
        form.classList.add('hidden');
        text.textContent = '+ Tambah Pertanyaan';
        btn.classList.remove('bg-red-600', 'hover:bg-red-700');
        btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
        // Reset form
        form.querySelector('form').reset();
    }
}

// Modal edit functions
function openEditModal(id, pertanyaan, tipe, skala, urutan) {
    document.getElementById('editId').value = id;
    document.getElementById('editPertanyaan').value = pertanyaan;
    document.getElementById('editTipe').value = tipe;
    document.getElementById('editSkala').value = skala;
    document.getElementById('editUrutan').value = urutan;
    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});
</script>

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
