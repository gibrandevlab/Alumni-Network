@extends('layouts.Dashboard.dashboard')

@section('title', 'Manajemen Event Kuesioner - ALUMNET')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<div class="flex min-h-screen">
    @include('layouts.Dashboard.sidebarkiri', [], ['class' => 'w-64 flex-shrink-0'])
    <div class="flex-1 ml-14 md:ml-64">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Manajemen Event Kuesioner</h1>
                        <p class="text-gray-600 mt-1">Kelola dan monitor event kuesioner alumni</p>
                    </div>
                    <button onclick="openEventModal()" class="btn-primary flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Event Baru
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="flex-1">
                    <div class="relative">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" id="searchInput" placeholder="Cari event kuesioner..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                </div>
                <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Non-aktif</option>
                    <option value="selesai">Selesai</option>
                </select>
                <select id="targetFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <option value="">Semua Target</option>
                    <option value="alumni">Alumni</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>

            <!-- Events Grid -->
            <div id="eventsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="card hover:shadow-lg transition-shadow event-card" data-event-id="{{ $event->id }}">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->judul_event }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($event->deskripsi_event, 100) }}</p>
                        </div>
                        <div class="ml-4">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($event->status == 'aktif') bg-green-100 text-green-800
                                @elseif($event->status == 'nonaktif') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $event->tahun_mulai }} - {{ $event->tahun_akhir }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $event->pertanyaan_count ?? 0 }} Pertanyaan</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>{{ $event->respon_count ?? 0 }} Respon</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button onclick="editEvent({{ $event->id }})" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-2 rounded text-sm transition-colors flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </button>
                        <button onclick="manageQuestions({{ $event->id }})" class="flex-1 btn-secondary text-sm flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Pertanyaan
                        </button>
                        <button onclick="downloadResponses({{ $event->id }})" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 px-3 py-2 rounded text-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </button>
                        <button onclick="confirmDelete('event', {{ $event->id }})" class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-2 rounded text-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12 hidden">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada event kuesioner</h3>
                <p class="text-gray-600 mb-4">Mulai dengan membuat event kuesioner pertama Anda</p>
                <button onclick="openEventModal()" class="btn-primary">
                    Buat Event Baru
                </button>
            </div>
        </div>

        <!-- Event Modal -->
        <div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-md w-full">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h3 id="eventModalTitle" class="text-lg font-semibold">Tambah Event Baru</h3>
                        <button onclick="closeEventModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form id="eventForm" class="p-6">
                        <input type="hidden" id="eventId" name="eventId">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Event</label>
                                <input type="text" id="judulEvent" name="judul_event" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea id="deskripsiEvent" name="deskripsi_event" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                                    <input type="number" id="tahunMulai" name="tahun_mulai" required min="2020" max="2030"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Akhir</label>
                                    <input type="number" id="tahunAkhir" name="tahun_akhir" required min="2020" max="2030"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select id="statusEvent" name="status" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non-aktif</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-3 mt-6">
                            <button type="button" onclick="closeEventModal()"
                                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit" id="eventSubmitBtn"
                                    class="flex-1 btn-primary">
                                <span class="btn-text">Simpan</span>
                                <svg class="w-4 h-4 animate-spin hidden btn-loading" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Questions Modal -->
        <div id="questionsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h3 id="questionsModalTitle" class="text-lg font-semibold">Kelola Pertanyaan</h3>
                        <div class="flex gap-2">
                            <button onclick="openQuestionModal()" class="btn-primary text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Pertanyaan
                            </button>
                            <button onclick="closeQuestionsModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                        <div id="questionsList" class="space-y-4">
                            <!-- Questions will be loaded here -->
                        </div>
                        <div id="questionsEmpty" class="text-center py-8 hidden">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600">Belum ada pertanyaan untuk event ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Question Form Modal -->
        <div id="questionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-60">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-md w-full">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h3 id="questionModalTitle" class="text-lg font-semibold">Tambah Pertanyaan</h3>
                        <button onclick="closeQuestionModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form id="questionForm" class="p-6">
                        @csrf
                        <input type="hidden" id="questionId" name="questionId">
                        <input type="hidden" id="questionEventId" name="eventId">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select id="kategori" name="kategori" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    <option value="umum">Umum</option>
                                    <option value="bekerja">Bekerja</option>
                                    <option value="pendidikan">Pendidikan</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Pertanyaan</label>
                                <select id="tipe" name="tipe" required onchange="toggleSkalaField()"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    <option value="likert">Likert Scale</option>
                                    <option value="esai">Esai</option>
                                    <option value="pilihan">Pilihan Ganda</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                                <input type="number" id="urutan" name="urutan" required min="1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                                <textarea id="pertanyaan" name="pertanyaan" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"></textarea>
                            </div>
                            <div id="skalaField">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Skala/Opsi</label>
                                <div id="skalaHint" class="text-sm text-gray-500 mb-1"></div>
                                <input type="text" id="skala" name="skala" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="flex gap-3 mt-6">
                            <button type="button" onclick="closeQuestionModal()"
                                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit" id="questionSubmitBtn"
                                    class="flex-1 btn-primary">
                                <span class="btn-text">Simpan</span>
                                <svg class="w-4 h-4 animate-spin hidden btn-loading" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-sm w-full">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold">Konfirmasi Hapus</h3>
                        </div>
                        <p id="confirmMessage" class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus item ini?</p>
                        <div class="flex gap-3">
                            <button onclick="closeConfirmModal()"
                                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                Batal
                            </button>
                            <button onclick="confirmDelete()" id="confirmDeleteBtn"
                                    class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                <span class="btn-text">Hapus</span>
                                <svg class="w-4 h-4 animate-spin hidden btn-loading" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification -->
        <div id="notification" class="fixed top-4 right-4 z-50 hidden">
            <div class="bg-white border-l-4 border-green-500 rounded-lg shadow-lg p-4 max-w-sm">
                <div class="flex items-center">
                    <svg id="notificationIcon" class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p id="notificationMessage" class="text-gray-800"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Global variables
    let currentEventId = null;
    let currentQuestionId = null;
    let deleteType = null;
    let deleteId = null;

    // CSRF Token setup
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Event Modal Functions
    function openEventModal(eventId = null) {
        const modal = document.getElementById('eventModal');
        const title = document.getElementById('eventModalTitle');
        const form = document.getElementById('eventForm');

        if (eventId) {
            title.textContent = 'Edit Event';
            // AJAX fetch event data
            fetch(`/dashboard/kuesioner/${eventId}/json`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.event) {
                        document.getElementById('eventId').value = data.event.id;
                        document.getElementById('judulEvent').value = data.event.judul_event || '';
                        document.getElementById('deskripsiEvent').value = data.event.deskripsi_event || '';
                        document.getElementById('tahunMulai').value = data.event.tahun_mulai || '';
                        document.getElementById('tahunAkhir').value = data.event.tahun_akhir || '';
                        document.getElementById('statusEvent').value = data.event.status || 'aktif';
                        modal.classList.remove('hidden');
                    } else {
                        showNotification('Data event tidak ditemukan', 'error');
                    }
                })
                .catch(() => {
                    showNotification('Gagal memuat data event', 'error');
                });
        } else {
            title.textContent = 'Tambah Event Baru';
            form.reset();
            document.getElementById('eventId').value = '';
            modal.classList.remove('hidden');
        }
    }

    function closeEventModal() {
        document.getElementById('eventModal').classList.add('hidden');
    }

    // Event Form Submit
    document.getElementById('eventForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('eventSubmitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Show loading state
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');
        submitBtn.disabled = true;

        const formData = new FormData(this);
        const eventId = document.getElementById('eventId').value;

        try {
            let url = '/dashboard/kuesioner';
            let method = 'POST';

            if (eventId) {
                url = `/dashboard/kuesioner/${eventId}`;
                method = 'PUT';
                formData.append('_method', 'PUT');
            }

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            });

            if (response.ok) {
                showNotification('Event berhasil disimpan!', 'success');
                closeEventModal();
                // Refresh the page or update the events list
                location.reload();
            } else {
                throw new Error('Gagal menyimpan event');
            }
        } catch (error) {
            showNotification('Gagal menyimpan event: ' + error.message, 'error');
        } finally {
            // Hide loading state
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
            submitBtn.disabled = false;
        }
    });

    // Edit Event
    function editEvent(eventId) {
        openEventModal(eventId);
    }

    // Questions Modal Functions
    function manageQuestions(eventId) {
        currentEventId = eventId;
        const modal = document.getElementById('questionsModal');
        const title = document.getElementById('questionsModalTitle');

        // Find event title
        const eventCard = document.querySelector(`[data-event-id="${eventId}"]`);
        const eventTitle = eventCard ? eventCard.querySelector('h3').textContent : 'Event';

        title.textContent = `Kelola Pertanyaan - ${eventTitle}`;
        modal.classList.remove('hidden');

        loadQuestions(eventId);
    }

    function closeQuestionsModal() {
        document.getElementById('questionsModal').classList.add('hidden');
        currentEventId = null;
    }

    async function loadQuestions(eventId) {
        try {
            const response = await fetch(`/dashboard/kuesioner/${eventId}/pertanyaan`);
            const data = await response.json();

            const questionsList = document.getElementById('questionsList');
            const questionsEmpty = document.getElementById('questionsEmpty');

            // FIX: handle both array and object response
            let pertanyaanArr = [];
            if (Array.isArray(data)) {
                pertanyaanArr = data;
            } else if (data.pertanyaan && Array.isArray(data.pertanyaan)) {
                pertanyaanArr = data.pertanyaan;
            }

            if (pertanyaanArr.length > 0) {
                questionsList.innerHTML = '';
                questionsEmpty.classList.add('hidden');

                pertanyaanArr.forEach(question => {
                    const questionCard = createQuestionCard(question);
                    questionsList.appendChild(questionCard);
                });
            } else {
                questionsList.innerHTML = '';
                questionsEmpty.classList.remove('hidden');
            }
        } catch (error) {
            showNotification('Gagal memuat pertanyaan: ' + error.message, 'error');
        }
    }

    function createQuestionCard(question) {
        const div = document.createElement('div');
        div.className = 'bg-gray-50 rounded-lg p-4 border';
        div.innerHTML = `
            <div class="flex justify-between items-start mb-2">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">${question.kategori}</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">${question.tipe}</span>
                        <span class="text-gray-500 text-xs">Urutan: ${question.urutan}</span>
                    </div>
                    <p class="text-gray-900 font-medium">${question.pertanyaan}</p>
                    ${question.skala ? `<p class="text-gray-600 text-sm mt-1">Skala/Opsi: ${question.skala}</p>` : ''}
                </div>
                <div class="flex gap-2 ml-4">
                    <button onclick="editQuestion(${question.id})" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button onclick="confirmDelete('question', ${question.id})" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        return div;
    }

    // Question Modal Functions
    function openQuestionModal(questionId = null) {
        const modal = document.getElementById('questionModal');
        const title = document.getElementById('questionModalTitle');
        const form = document.getElementById('questionForm');

        document.getElementById('questionEventId').value = currentEventId;

        if (questionId) {
            title.textContent = 'Edit Pertanyaan';
            currentQuestionId = questionId;
            // AJAX fetch question data
            fetch(`/dashboard/kuesioner/${currentEventId}/pertanyaan/${questionId}/json`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.pertanyaan) {
                        document.getElementById('questionId').value = data.pertanyaan.id;
                        document.getElementById('questionEventId').value = data.pertanyaan.event_kuesioner_id || currentEventId;
                        document.getElementById('kategori').value = data.pertanyaan.kategori || '';
                        document.getElementById('tipe').value = data.pertanyaan.tipe || 'likert';
                        document.getElementById('urutan').value = data.pertanyaan.urutan || '';
                        document.getElementById('pertanyaan').value = data.pertanyaan.pertanyaan || '';
                        document.getElementById('skala').value = Array.isArray(data.pertanyaan.skala) ? data.pertanyaan.skala.join(',') : (data.pertanyaan.skala || '');
                        toggleSkalaField();
                        modal.classList.remove('hidden');
                    } else {
                        showNotification('Data pertanyaan tidak ditemukan', 'error');
                    }
                })
                .catch(() => {
                    showNotification('Gagal memuat data pertanyaan', 'error');
                });
        } else {
            title.textContent = 'Tambah Pertanyaan';
            form.reset();
            document.getElementById('questionId').value = '';
            document.getElementById('questionEventId').value = currentEventId;
            currentQuestionId = null;
            modal.classList.remove('hidden');
            toggleSkalaField();
        }
    }

    function closeQuestionModal() {
        document.getElementById('questionModal').classList.add('hidden');
        currentQuestionId = null;
    }

    function toggleSkalaField() {
        const tipe = document.getElementById('tipe').value;
        const skalaField = document.getElementById('skalaField');
        const skalaHint = document.getElementById('skalaHint');
        const skalaInput = document.getElementById('skala');

        if (tipe === 'esai') {
            skalaField.style.display = 'none';
            skalaInput.value = '';
        } else {
            skalaField.style.display = 'block';
            if (tipe === 'likert') {
                skalaHint.textContent = 'Masukkan rentang skala (contoh: 1-5)';
                skalaInput.placeholder = '1-5';
            } else if (tipe === 'pilihan') {
                skalaHint.textContent = 'Masukkan opsi jawaban dipisahkan dengan koma (contoh: Sangat Setuju,Setuju,Ragu-ragu,Tidak Setuju,Sangat Tidak Setuju)';
                skalaInput.placeholder = 'Opsi 1,Opsi 2,Opsi 3';
            }
        }
    }

    // Question Form Submit
    document.getElementById('questionForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('questionSubmitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Show loading state
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');
        submitBtn.disabled = true;

        const formData = new FormData(this);
        const questionId = document.getElementById('questionId').value;

        try {
            let url = `/dashboard/kuesioner/${currentEventId}/pertanyaan`;
            let method = 'POST';

            if (questionId) {
                url = `/dashboard/kuesioner/${currentEventId}/pertanyaan/${questionId}`;
                method = 'PUT';
                formData.append('_method', 'PUT');
            }

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            });

            if (response.ok) {
                showNotification('Pertanyaan berhasil disimpan!', 'success');
                closeQuestionModal();
                loadQuestions(currentEventId);
            } else {
                throw new Error('Gagal menyimpan pertanyaan');
            }
        } catch (error) {
            showNotification('Gagal menyimpan pertanyaan: ' + error.message, 'error');
        } finally {
            // Hide loading state
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
            submitBtn.disabled = false;
        }
    });

    function editQuestion(questionId) {
        openQuestionModal(questionId);
    }

    // Delete Confirmation
    function confirmDelete(type, id) {
        deleteType = type;
        deleteId = id;

        const modal = document.getElementById('confirmModal');
        const message = document.getElementById('confirmMessage');

        if (type === 'event') {
            message.textContent = 'Apakah Anda yakin ingin menghapus event ini? Semua pertanyaan dan respon akan ikut terhapus.';
        } else {
            message.textContent = 'Apakah Anda yakin ingin menghapus pertanyaan ini?';
        }

        modal.classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        deleteType = null;
        deleteId = null;
    }

    async function confirmDelete() {
        const submitBtn = document.getElementById('confirmDeleteBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Show loading state
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');
        submitBtn.disabled = true;

        try {
            let url;
            if (deleteType === 'event') {
                url = `/dashboard/kuesioner/${deleteId}`;
            } else {
                url = `/dashboard/kuesioner/${currentEventId}/pertanyaan/${deleteId}`;
            }

            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                }
            });

            if (response.ok) {
                showNotification(`${deleteType === 'event' ? 'Event' : 'Pertanyaan'} berhasil dihapus!`, 'success');
                closeConfirmModal();

                if (deleteType === 'event') {
                    location.reload();
                } else {
                    loadQuestions(currentEventId);
                }
            } else {
                throw new Error(`Gagal menghapus ${deleteType}`);
            }
        } catch (error) {
            showNotification(`Gagal menghapus ${deleteType}: ` + error.message, 'error');
        } finally {
            // Hide loading state
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
            submitBtn.disabled = false;
        }
    }

    // Download Responses
    async function downloadResponses(eventId) {
        try {
            const response = await fetch(`/dashboard/kuesioner/${eventId}/download-respon`);

            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `respon-kuesioner-${eventId}.xlsx`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);

                showNotification('File berhasil diunduh!', 'success');
            } else {
                throw new Error('Gagal mengunduh file');
            }
        } catch (error) {
            showNotification('Gagal mengunduh file: ' + error.message, 'error');
        }
    }

    // Notification Function
    function showNotification(message, type = 'success') {
        const notification = document.getElementById('notification');
        const icon = document.getElementById('notificationIcon');
        const messageEl = document.getElementById('notificationMessage');

        messageEl.textContent = message;

        if (type === 'success') {
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>`;
            icon.className = 'w-6 h-6 text-green-500 mr-3';
            notification.querySelector('div').className = 'bg-white border-l-4 border-green-500 rounded-lg shadow-lg p-4 max-w-sm';
        } else {
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>`;
            icon.className = 'w-6 h-6 text-red-500 mr-3';
            notification.querySelector('div').className = 'bg-white border-l-4 border-red-500 rounded-lg shadow-lg p-4 max-w-sm';
        }

        notification.classList.remove('hidden');

        setTimeout(() => {
            notification.classList.add('hidden');
        }, 5000);
    }

    // Search and Filter Functions
    document.getElementById('searchInput').addEventListener('input', filterEvents);
    document.getElementById('statusFilter').addEventListener('change', filterEvents);
    document.getElementById('targetFilter').addEventListener('change', filterEvents);

    function filterEvents() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const targetFilter = document.getElementById('targetFilter').value;

        const eventCards = document.querySelectorAll('.event-card');
        let visibleCount = 0;

        eventCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.querySelector('p').textContent.toLowerCase();
            const status = card.querySelector('.px-2.py-1').textContent.toLowerCase().trim();

            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesStatus = !statusFilter || status === statusFilter;
            // Target filter would need additional data attribute or API call
            const matchesTarget = true; // Placeholder

            if (matchesSearch && matchesStatus && matchesTarget) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state
        const emptyState = document.getElementById('emptyState');
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there are no events to show empty state
        const eventCards = document.querySelectorAll('.event-card');
        if (eventCards.length === 0) {
            document.getElementById('emptyState').classList.remove('hidden');
        }
    });
</script>
@endsection
