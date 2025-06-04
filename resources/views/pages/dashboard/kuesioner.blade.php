@extends('layouts.Dashboard.dashboard')

@section('title', 'Manajemen Event Kuesioner - ALUMNET')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    @include('layouts.Dashboard.sidebarkiri', [], ['class' => 'w-64 flex-shrink-0'])

    <div class="flex-1 flex flex-col min-w-0 p-6 overflow-x-auto ml-14 md:ml-64" id="mainContentainer">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manajemen Event Kuesioner</h1>
                    <p class="text-gray-600 mt-2">Kelola dan monitor event kuesioner alumni</p>
                </div>
                <a href="#" id="btn-tambah-kuesioner"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Kuesioner Baru
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Event Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($events as $event)
                @php
                    $showProgress = $event->target_peserta === 'alumni' && (auth()->user()?->status === 'approved');
                @endphp

                <div class="group bg-white/80 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border-0">
                    <!-- Card Header -->
                    <div class="p-6 pb-3">
                        <div class="flex items-start justify-between mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $event->status_class }}">
                                {{ $event->status_text }}
                            </span>
                            <div class="relative">
                                <button class="dropdown-toggle opacity-0 group-hover:opacity-100 transition-opacity p-1 rounded-md hover:bg-gray-100"
                                        onclick="toggleDropdown({{ $event->id }})">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </button>
                                <div id="dropdown-{{ $event->id }}" class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-10">
                                    <div class="py-1">
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 download-respon-btn" data-event-id="{{ $event->id }}">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Download Jawaban
                                        </a>
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 edit-pertanyaan-btn" data-event-id="{{ $event->id }}">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit Pertanyaan
                                        </a>
                                        <div class="border-t border-gray-100"></div>
                                        <button onclick="confirmDelete({{ $event->id }})" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus Event
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <img src="{{ $event->foto ?? '/images/defaultkuesioner.png' }}"
                                 alt="{{ $event->judul_event }}"
                                 class="w-full h-40 object-cover rounded-lg border border-gray-200">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2">{{ $event->judul_event }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ Str::limit($event->deskripsi_event, 120) }}</p>
                                <div class="text-xs text-blue-400 mt-1">Target Peserta: {{ $event->target_peserta ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="px-6 space-y-4">
                        <!-- Event Details -->
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Periode: {{ $event->tahun_mulai }} - {{ $event->tahun_akhir }}</span>
                            </div>
                            @if($event->tahun_lulusan)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                <span>Lulusan: {{ $event->tahun_lulusan }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Progress Bar -->
                        @if($showProgress)
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Respons</span>
                                <span class="font-medium text-gray-900">{{ $event->responses }}/{{ $event->target }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-300"
                                     style="width: {{ $event->progress }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500">{{ round($event->progress) }}% tercapai</div>
                        </div>
                        @endif
                    </div>

                    <!-- Card Footer -->
                    <div class="p-6 pt-0">
                        <div class="flex gap-2 w-full">
                            <a href="{{ route('dashboard.kuesioner.edit', $event->id) }}"
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <button class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </button>
                        </div>
                    </div>

                    <!-- Hidden Delete Form -->
                    <form id="delete-form-{{ $event->id }}" action="{{ route('dashboard.kuesioner.destroy', $event->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada event</h3>
                    <p class="text-gray-600 mb-6">Mulai dengan membuat event kuesioner pertama Anda</p>
                    <a href="{{ route('dashboard.kuesioner.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        Tambah Event Baru
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Pop Up Form Tambah Event Kuesioner -->
<div id="modal-tambah-kuesioner" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-8 relative">
        <button onclick="closeModal('modal-tambah-kuesioner')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <h2 class="text-xl font-bold mb-4">Tambah Kuesioner Baru</h2>
        <form id="form-tambah-kuesioner" method="POST" action="{{ route('dashboard.kuesioner.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Judul Event</label>
                <input type="text" name="judul_event" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Deskripsi Event</label>
                <textarea name="deskripsi_event" class="w-full border rounded px-3 py-2" required></textarea>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Tahun Mulai</label>
                    <input type="number" name="tahun_mulai" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Tahun Akhir</label>
                    <input type="number" name="tahun_akhir" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Target Peserta</label>
                <select name="target_peserta" class="w-full border rounded px-3 py-2" required>
                    <option value="alumni">Alumni</option>
                    <option value="mahasiswa">Mahasiswa</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Foto (opsional)</label>
                <input type="file" name="foto" class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('modal-tambah-kuesioner')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Event Kuesioner (untuk tombol Edit di footer card) -->
<div id="modal-edit-event" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-8 relative">
        <button onclick="closeModal('modal-edit-event')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <h2 class="text-xl font-bold mb-4">Edit Event Kuesioner</h2>
        <form id="form-edit-event" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="event_id" id="edit-event-id">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Judul Event</label>
                <input type="text" name="judul_event" id="edit-judul-event" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Deskripsi Event</label>
                <textarea name="deskripsi_event" id="edit-deskripsi-event" class="w-full border rounded px-3 py-2" required></textarea>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Tahun Mulai</label>
                    <input type="number" name="tahun_mulai" id="edit-tahun-mulai" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Tahun Akhir</label>
                    <input type="number" name="tahun_akhir" id="edit-tahun-akhir" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Target Peserta</label>
                <select name="target_peserta" id="edit-target-peserta" class="w-full border rounded px-3 py-2" required>
                    <option value="alumni">Alumni</option>
                    <option value="mahasiswa">Mahasiswa</option>
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('modal-edit-event')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pertanyaan Kuesioner (untuk tombol Edit Event di dropdown) -->
<div id="modal-edit-pertanyaan" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-8 relative">
        <button onclick="closeModal('modal-edit-pertanyaan')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <h2 class="text-xl font-bold mb-4">Edit Pertanyaan Kuesioner</h2>
        <div id="pertanyaan-form-container">
            <!-- Dynamic form pertanyaan akan di-load via AJAX atau JS -->
            <div class="text-gray-500 text-center">Memuat data pertanyaan...</div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btn-tambah-kuesioner').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('modal-tambah-kuesioner').classList.remove('hidden');
    });
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>

<!-- JavaScript for Dropdown and Delete Confirmation -->
<script>
    // Toggle dropdown menu
    function toggleDropdown(eventId) {
        const dropdown = document.getElementById(`dropdown-${eventId}`);
        const allDropdowns = document.querySelectorAll('.dropdown-menu');

        // Close all other dropdowns
        allDropdowns.forEach(menu => {
            if (menu.id !== `dropdown-${eventId}`) {
                menu.classList.add('hidden');
            }
        });

        // Toggle current dropdown
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown-toggle') && !event.target.closest('.dropdown-menu')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    // Confirm delete
    function confirmDelete(eventId) {
        if (confirm('Apakah Anda yakin ingin menghapus event ini? Tindakan ini tidak dapat dibatalkan.')) {
            document.getElementById(`delete-form-${eventId}`).submit();
        }
    }

    // Add line-clamp styles if not available
    const style = document.createElement('style');
    style.textContent = `
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    `;
    document.head.appendChild(style);

    // Tombol Edit Event (footer card) - buka modal edit event
    document.querySelectorAll('.edit-event-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const event = JSON.parse(this.dataset.event);
            document.getElementById('edit-event-id').value = event.id;
            document.getElementById('edit-judul-event').value = event.judul_event;
            document.getElementById('edit-deskripsi-event').value = event.deskripsi_event;
            document.getElementById('edit-tahun-mulai').value = event.tahun_mulai;
            document.getElementById('edit-tahun-akhir').value = event.tahun_akhir;
            document.getElementById('edit-target-peserta').value = event.target_peserta;
            document.getElementById('form-edit-event').action = `/dashboard/kuesioner/${event.id}`;
            document.getElementById('modal-edit-event').classList.remove('hidden');
        });
    });
    // Tombol Edit Pertanyaan (dropdown) - buka modal edit pertanyaan dan load data
    document.querySelectorAll('.edit-pertanyaan-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const eventId = this.dataset.eventId;
            const container = document.getElementById('pertanyaan-form-container');
            container.innerHTML = '<div class="text-gray-500 text-center">Memuat data pertanyaan...</div>';
            fetch(`/dashboard/kuesioner/${eventId}/pertanyaan`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        container.innerHTML = '<div class="text-center text-gray-500">Belum ada pertanyaan. Silakan tambahkan pertanyaan baru.</div>';
                    } else {
                        let html = '<div class="space-y-4">';
                        data.forEach((q, i) => {
                            html += `<div class='border rounded p-3'><div class='font-semibold mb-1'>${i+1}. ${q.pertanyaan}</div><div class='text-xs text-gray-500'>Kategori: ${q.kategori} | Tipe: ${q.tipe} | Urutan: ${q.urutan}</div></div>`;
                        });
                        html += '</div>';
                        container.innerHTML = html;
                    }
                });
            document.getElementById('modal-edit-pertanyaan').classList.remove('hidden');
        });
    });
    // Download Jawaban Respon Kuesioner
    document.querySelectorAll('.download-respon-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const eventId = this.dataset.eventId;
            window.location.href = `/dashboard/kuesioner/${eventId}/download-respon`;
        });
    });
</script>

@endsection
