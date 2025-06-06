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
                    <button id="btn-tambah-event"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Event Baru
                    </button>
                </div>
            </div>

            <!-- Notification Area -->
            <div id="notification-area" class="hidden mb-6 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg id="notification-icon" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span id="notification-message"></span>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="mb-6 flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" id="search-events" placeholder="Cari event kuesioner..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <div class="flex gap-2">
                    <select id="filter-status"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="draft">Draft</option>
                        <option value="active">Aktif</option>
                        <option value="completed">Selesai</option>
                    </select>
                    <select id="filter-target"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Target</option>
                        <option value="alumni">Alumni</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="umum">Umum</option>
                    </select>
                </div>
            </div>

            <!-- Event Cards Grid -->
            <div id="events-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Cards akan dimuat via AJAX -->
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="hidden text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada event</h3>
                <p class="text-gray-600 mb-6">Mulai dengan membuat event kuesioner pertama Anda</p>
                <button id="btn-tambah-event-empty"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    Tambah Event Baru
                </button>
            </div>

            <!-- Loading State -->
            <div id="loading-state" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Skeleton cards -->
                <div class="animate-pulse">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                        <div class="h-32 bg-gray-200 rounded mb-4"></div>
                        <div class="space-y-2">
                            <div class="h-3 bg-gray-200 rounded"></div>
                            <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                        </div>
                    </div>
                </div>
                <div class="animate-pulse">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                        <div class="h-32 bg-gray-200 rounded mb-4"></div>
                        <div class="space-y-2">
                            <div class="h-3 bg-gray-200 rounded"></div>
                            <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                        </div>
                    </div>
                </div>
                <div class="animate-pulse">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                        <div class="h-32 bg-gray-200 rounded mb-4"></div>
                        <div class="space-y-2">
                            <div class="h-3 bg-gray-200 rounded"></div>
                            <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Event -->
    <div id="modal-event" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
        style="display:none">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal('modal-event')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <h2 id="modal-event-title" class="text-xl font-bold mb-4">Tambah Event Baru</h2>
            <form id="form-event">
                <input type="hidden" id="event-id" name="event_id">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Judul Event <span class="text-red-500">*</span></label>
                    <input type="text" id="judul-event" name="judul_event" class="w-full border rounded px-3 py-2"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Deskripsi Event <span
                            class="text-red-500">*</span></label>
                    <textarea id="deskripsi-event" name="deskripsi_event" class="w-full border rounded px-3 py-2" rows="3"
                        required></textarea>
                </div>
                <div class="mb-4 flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1">Tanggal Mulai <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="tanggal-mulai" name="tanggal_mulai"
                            class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1">Tanggal Selesai <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="tanggal-selesai" name="tanggal_selesai"
                            class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Target Peserta <span
                            class="text-red-500">*</span></label>
                    <select id="target-peserta" name="target_peserta" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Target Peserta</option>
                        <option value="alumni">Alumni</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="umum">Umum</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Tahun Lulusan (opsional)</label>
                    <input type="number" id="tahun-lulusan" name="tahun_lulusan"
                        class="w-full border rounded px-3 py-2" min="1990" max="2030">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select id="status-event" name="status" class="w-full border rounded px-3 py-2">
                        <option value="draft">Draft</option>
                        <option value="active">Aktif</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-event')"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" id="btn-submit-event"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Kelola Pertanyaan -->
    <div id="modal-pertanyaan" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
        style="display:none">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal('modal-pertanyaan')"
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <h2 id="modal-pertanyaan-title" class="text-xl font-bold mb-4">Kelola Pertanyaan</h2>

            <div class="mb-4">
                <button id="btn-tambah-pertanyaan"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pertanyaan
                </button>
            </div>

            <!-- Tabel Pertanyaan -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pertanyaan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="pertanyaan-tbody" class="bg-white divide-y divide-gray-200">
                        <!-- Data akan dimuat via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Pertanyaan -->
    <div id="modal-form-pertanyaan" class="fixed inset-0 z-60 flex items-center justify-center bg-black bg-opacity-40"
        style="display:none">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal('modal-form-pertanyaan')"
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <h2 id="modal-form-pertanyaan-title" class="text-xl font-bold mb-4">Tambah Pertanyaan</h2>
            <form id="form-pertanyaan">
                <input type="hidden" id="pertanyaan-id" name="pertanyaan_id">
                <input type="hidden" id="pertanyaan-event-id" name="event_id">

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select id="kategori-pertanyaan" name="kategori" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Kategori</option>
                        <option value="umum">Umum</option>
                        <option value="bekerja">Bekerja</option>
                        <option value="pendidikan">Pendidikan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Tipe Pertanyaan <span
                            class="text-red-500">*</span></label>
                    <select id="tipe-pertanyaan" name="tipe" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Tipe</option>
                        <option value="esai">Esai</option>
                        <option value="pilihan_ganda">Pilihan Ganda</option>
                        <option value="skala">Skala</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Urutan <span class="text-red-500">*</span></label>
                    <input type="number" id="urutan-pertanyaan" name="urutan" class="w-full border rounded px-3 py-2"
                        min="1" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea id="text-pertanyaan" name="pertanyaan" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
                </div>

                <div id="skala-container" class="mb-4 hidden">
                    <label class="block text-sm font-medium mb-1">Pilihan/Skala</label>
                    <div id="skala-list" class="space-y-2">
                        <!-- Pilihan akan ditambahkan secara dinamis -->
                    </div>
                    <button type="button" id="btn-tambah-skala"
                        class="mt-2 px-3 py-1 bg-gray-200 rounded text-sm hover:bg-gray-300">
                        Tambah Pilihan
                    </button>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-form-pertanyaan')"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" id="btn-submit-pertanyaan"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Isi Respon -->
    <div id="modal-respon" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
        style="display:none">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal('modal-respon')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <h2 id="modal-respon-title" class="text-xl font-bold mb-4">Isi Kuesioner</h2>
            <form id="form-respon">
                <input type="hidden" id="respon-event-id" name="event_id">

                <!-- Email field untuk guest user -->
                <div id="email-container" class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email-respon" name="email" class="w-full border rounded px-3 py-2"
                        required>
                </div>

                <div id="pertanyaan-respon-container">
                    <!-- Pertanyaan akan dimuat secara dinamis -->
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeModal('modal-respon')"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" id="btn-submit-respon"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit Respon</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Global variables
            let allEvents = [];
            let filteredEvents = [];
            let currentEventId = null;
            let currentPertanyaanId = null;
            let isEditMode = false;

            // CSRF Token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            // Utility functions
            function normalizeStatus(status) {
                if (status === 'aktif') return 'active';
                if (status === 'selesai') return 'completed';
                return status;
            }

            function showNotification(message, type = 'success') {
                const notificationArea = document.getElementById('notification-area');
                const notificationMessage = document.getElementById('notification-message');
                const notificationIcon = document.getElementById('notification-icon');

                notificationMessage.textContent = message;
                notificationArea.className =
                    `mb-6 p-4 rounded-lg ${type === 'success' ? 'bg-green-100 border border-green-200 text-green-700' : 'bg-red-100 border border-red-200 text-red-700'}`;
                notificationArea.classList.remove('hidden');

                setTimeout(() => {
                    notificationArea.classList.add('hidden');
                }, 5000);
            }

            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }

            function openModal(modalId) {
                document.getElementById(modalId).style.display = 'flex';
            }

            function showLoading() {
                document.getElementById('loading-state').classList.remove('hidden');
                document.getElementById('events-container').classList.add('hidden');
                document.getElementById('empty-state').classList.add('hidden');
            }

            function hideLoading() {
                document.getElementById('loading-state').classList.add('hidden');
            }

            // Global functions for inline event handlers
            window.toggleDropdown = function(eventId) {
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

            window.editEvent = async function(eventId) {
                try {
                    isEditMode = true;
                    currentEventId = eventId;
                    document.getElementById('modal-event-title').textContent = 'Edit Event';
                    document.getElementById('event-id').value = eventId;

                    // Find event in current data
                    const event = allEvents.find(e => e.id === eventId);
                    if (!event) {
                        throw new Error('Event not found');
                    }

                    // Populate form
                    document.getElementById('judul-event').value = event.judul_event;
                    document.getElementById('deskripsi-event').value = event.deskripsi_event;
                    document.getElementById('tanggal-mulai').value = event.tanggal_mulai;
                    document.getElementById('tanggal-selesai').value = event.tanggal_selesai;
                    document.getElementById('target-peserta').value = event.target_peserta;
                    document.getElementById('tahun-lulusan').value = event.tahun_lulusan || '';
                    document.getElementById('status-event').value = event.status;

                    openModal('modal-event');
                } catch (error) {
                    console.error('Error loading event:', error);
                    showNotification('Gagal memuat data event', 'error');
                }
            }

            window.deleteEvent = async function(eventId) {
                if (!confirm('Apakah Anda yakin ingin menghapus event ini? Tindakan ini tidak dapat dibatalkan.')) {
                    return;
                }

                try {
                    const formData = new FormData();
                    formData.append('id', eventId);
                    const response = await fetch(`/dashboard/kuesioner/delete`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showNotification('Event berhasil dihapus');
                        loadEvents();
                    } else {
                        throw new Error(data.message || 'Gagal menghapus event');
                    }
                } catch (error) {
                    console.error('Error deleting event:', error);
                    showNotification(error.message, 'error');
                }
            }

            window.kelolaPertanyaan = async function(eventId) {
                currentEventId = eventId;
                const event = allEvents.find(e => e.id === eventId);
                document.getElementById('modal-pertanyaan-title').textContent =
                    `Kelola Pertanyaan - ${event?.judul_event || 'Event ID: ' + eventId}`;
                await loadPertanyaan(eventId);
                openModal('modal-pertanyaan');
            }

            window.downloadRespon = function(eventId) {
                window.open(`/dashboard/kuesioner/${eventId}/download-respon`, '_blank');
            }

            window.isiRespon = async function(eventId) {
                currentEventId = eventId;
                const event = allEvents.find(e => e.id === eventId);
                document.getElementById('modal-respon-title').textContent =
                    `Isi Kuesioner - ${event?.judul_event || 'Event'}`;
                document.getElementById('respon-event-id').value = eventId;

                // Check if user is logged in
                const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

                if (isLoggedIn) {
                    document.getElementById('email-container').style.display = 'none';
                } else {
                    document.getElementById('email-container').style.display = 'block';
                }

                await loadPertanyaanForRespon(eventId);
                openModal('modal-respon');
            }

            window.addSkalaItem = function(value = '') {
                const skalaList = document.getElementById('skala-list');
                const index = Date.now();

                const div = document.createElement('div');
                div.className = 'flex gap-2';
                div.innerHTML = `
        <input type="text" name="skala[]" value="${value}" class="flex-1 border rounded px-3 py-2" placeholder="Masukkan pilihan">
        <button type="button" onclick="this.parentElement.remove()" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
    `;

                skalaList.appendChild(div);
            }

            // Load events data
            async function loadEvents() {
                showLoading();
                try {
                    const response = await fetch('/dashboard/kuesioner', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (!response.ok) throw new Error('Failed to load events');

                    const data = await response.json();
                    allEvents = data.data;
                    filteredEvents = [...allEvents];
                    renderEventsCards(filteredEvents);
                } catch (error) {
                    console.error('Error loading events:', error);
                    showNotification('Gagal memuat data event', 'error');
                    allEvents = [];
                    filteredEvents = [];
                    showEmptyState();
                } finally {
                    hideLoading();
                }
            }

            // Render events cards
            function renderEventsCards(events) {
                const container = document.getElementById('events-container');
                const emptyState = document.getElementById('empty-state');

                if (!events || events.length === 0) {
                    showEmptyState();
                    return;
                }

                container.classList.remove('hidden');
                emptyState.classList.add('hidden');

                container.innerHTML = events.map(event => createEventCard(event)).join('');
            }

            function showEmptyState() {
                document.getElementById('events-container').classList.add('hidden');
                document.getElementById('empty-state').classList.remove('hidden');
            }

            // Create event card HTML
            function createEventCard(event) {
                const statusClass = getStatusClass(normalizeStatus(event.status));
                const statusText = getStatusText(normalizeStatus(event.status));

                return `
        <div class="group bg-white/80 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border-0 overflow-hidden">
            <!-- Card Header -->
            <div class="relative">
                <img src="${event.foto || '/images/defaultkuesioner.png'}"
                     alt="${event.judul_event}"
                     class="w-full h-48 object-cover">
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                        ${statusText}
                    </span>
                </div>
                <div class="absolute top-4 left-4">
                    <div class="relative">
                        <button class="dropdown-toggle opacity-0 group-hover:opacity-100 transition-opacity p-2 rounded-full bg-white/80 hover:bg-white"
                                onclick="toggleDropdown(${event.id})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                        <div id="dropdown-${event.id}" class="dropdown-menu hidden absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-10">
                            <div class="py-1">
                                <button onclick="downloadRespon(${event.id})" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Respon
                                </button>
                                <button onclick="isiRespon(${event.id})" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Isi/Lihat Respon
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Content -->
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2">${event.judul_event}</h3>
                    <p class="text-sm text-gray-600 line-clamp-3">${event.deskripsi_event || 'Tidak ada deskripsi'}</p>
                </div>

                <!-- Event Details -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>${event.tanggal_mulai} - ${event.tanggal_selesai}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <span>Target: ${event.target_peserta}</span>
                    </div>
                    ${event.tahun_lulusan ? `
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                </svg>
                                <span>Lulusan: ${event.tahun_lulusan}</span>
                            </div>
                            ` : ''}
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Respon: ${event.respon_count || 0}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button onclick="editEvent(${event.id})" class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </button>
                    <button onclick="kelolaPertanyaan(${event.id})" class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pertanyaan
                    </button>
                    <button onclick="deleteEvent(${event.id})" class="px-3 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;
            }

            function getStatusClass(status) {
                switch (status) {
                    case 'active':
                        return 'bg-green-100 text-green-800';
                    case 'draft':
                        return 'bg-yellow-100 text-yellow-800';
                    case 'completed':
                        return 'bg-gray-100 text-gray-800';
                    default:
                        return 'bg-gray-100 text-gray-800';
                }
            }

            function getStatusText(status) {
                switch (status) {
                    case 'active':
                        return 'Aktif';
                    case 'draft':
                        return 'Draft';
                    case 'completed':
                        return 'Selesai';
                    default:
                        return status;
                }
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown-toggle') && !event.target.closest('.dropdown-menu')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.add('hidden');
                    });
                }
            });

            // Search and filter functionality
            document.getElementById('search-events').addEventListener('input', function() {
                filterEvents();
            });

            document.getElementById('filter-status').addEventListener('change', function() {
                filterEvents();
            });

            document.getElementById('filter-target').addEventListener('change', function() {
                filterEvents();
            });

            function filterEvents() {
                const searchTerm = document.getElementById('search-events').value.toLowerCase();
                const statusFilter = document.getElementById('filter-status').value;
                const targetFilter = document.getElementById('filter-target').value;

                filteredEvents = allEvents.filter(event => {
                    const matchesSearch = event.judul_event.toLowerCase().includes(searchTerm) ||
                        (event.deskripsi_event && event.deskripsi_event.toLowerCase().includes(searchTerm));
                    const matchesStatus = !statusFilter || normalizeStatus(event.status) === statusFilter;
                    const matchesTarget = !targetFilter || event.target_peserta === targetFilter;

                    return matchesSearch && matchesStatus && matchesTarget;
                });

                renderEventsCards(filteredEvents);
            }

            // Event handlers
            document.getElementById('btn-tambah-event').addEventListener('click', () => {
                isEditMode = false;
                currentEventId = null;
                document.getElementById('modal-event-title').textContent = 'Tambah Event Baru';
                document.getElementById('form-event').reset();
                openModal('modal-event');
            });

            document.getElementById('btn-tambah-event-empty').addEventListener('click', () => {
                isEditMode = false;
                currentEventId = null;
                document.getElementById('modal-event-title').textContent = 'Tambah Event Baru';
                document.getElementById('form-event').reset();
                openModal('modal-event');
            });

            // Form event submit
            document.getElementById('form-event').addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                const submitBtn = document.getElementById('btn-submit-event');
                const originalText = submitBtn.textContent;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Menyimpan...';

                try {
                    let url;
                    if (isEditMode) {
                        url = "/dashboard/kuesioner/edit";
                        formData.append('id', currentEventId);
                    } else {
                        url = "/dashboard/kuesioner/create";
                    }

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showNotification(isEditMode ? 'Event berhasil diperbarui' : 'Event berhasil ditambahkan');
                        closeModal('modal-event');
                        loadEvents();
                    } else {
                        throw new Error(data.message || 'Gagal menyimpan event');
                    }
                } catch (error) {
                    console.error('Error saving event:', error);
                    showNotification(error.message, 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });

            // Load pertanyaan
            async function loadPertanyaan(eventId) {
                try {
                    const response = await fetch(`/dashboard/kuesioner/${eventId}/pertanyaan-list`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (!response.ok) throw new Error('Failed to load pertanyaan');

                    const pertanyaan = await response.json();
                    renderPertanyaanTable(pertanyaan.data);
                } catch (error) {
                    console.error('Error loading pertanyaan:', error);
                    showNotification('Gagal memuat data pertanyaan', 'error');
                }
            }

            // Render pertanyaan table
            function renderPertanyaanTable(pertanyaan) {
                const tbody = document.getElementById('pertanyaan-tbody');

                if (!pertanyaan || pertanyaan.length === 0) {
                    tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    Belum ada pertanyaan
                </td>
            </tr>
        `;
                    return;
                }

                tbody.innerHTML = pertanyaan.map((p, index) => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${p.kategori}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${p.tipe}</td>
            <td class="px-6 py-4 text-sm text-gray-900">${p.pertanyaan}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                <button onclick="editPertanyaan(${p.id})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                <button onclick="deletePertanyaan(${p.id})" class="text-red-600 hover:text-red-900">Hapus</button>
            </td>
        </tr>
    `).join('');
            }

            window.editPertanyaan = async function(pertanyaanId) {
                try {
                    isEditMode = true;
                    currentPertanyaanId = pertanyaanId;
                    document.getElementById('modal-form-pertanyaan-title').textContent = 'Edit Pertanyaan';
                    document.getElementById('pertanyaan-id').value = pertanyaanId;

                    // Fetch pertanyaan data
                    const response = await fetch(`/dashboard/kuesioner/${currentEventId}/pertanyaan/${pertanyaanId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (!response.ok) throw new Error('Failed to load pertanyaan data');

                    const pertanyaan = await response.json();

                    // Populate form
                    document.getElementById('kategori-pertanyaan').value = pertanyaan.kategori;
                    document.getElementById('tipe-pertanyaan').value = pertanyaan.tipe;
                    document.getElementById('urutan-pertanyaan').value = pertanyaan.urutan;
                    document.getElementById('text-pertanyaan').value = pertanyaan.pertanyaan;

                    // Handle skala
                    if (pertanyaan.skala && (pertanyaan.tipe === 'pilihan_ganda' || pertanyaan.tipe === 'skala')) {
                        const skalaArray = Array.isArray(pertanyaan.skala) ? pertanyaan.skala : JSON.parse(pertanyaan
                            .skala || '[]');
                        populateSkalaList(skalaArray);
                        document.getElementById('skala-container').classList.remove('hidden');
                    } else {
                        document.getElementById('skala-container').classList.add('hidden');
                    }

                    openModal('modal-form-pertanyaan');
                } catch (error) {
                    console.error('Error loading pertanyaan:', error);
                    showNotification('Gagal memuat data pertanyaan', 'error');
                }
            }

            window.deletePertanyaan = async function(pertanyaanId) {
                if (!confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')) {
                    return;
                }

                try {
                    const formData = new FormData();
                    formData.append('id', pertanyaanId);
                    const response = await fetch(`/dashboard/kuesioner/pertanyaan/delete`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showNotification('Pertanyaan berhasil dihapus');
                        loadPertanyaan(currentEventId);
                    } else {
                        throw new Error(data.message || 'Gagal menghapus pertanyaan');
                    }
                } catch (error) {
                    console.error('Error deleting pertanyaan:', error);
                    showNotification(error.message, 'error');
                }
            }

            // Tambah pertanyaan
            document.getElementById('btn-tambah-pertanyaan').addEventListener('click', () => {
                isEditMode = false;
                currentPertanyaanId = null;
                document.getElementById('modal-form-pertanyaan-title').textContent = 'Tambah Pertanyaan';
                document.getElementById('form-pertanyaan').reset();
                document.getElementById('pertanyaan-event-id').value = currentEventId;
                clearSkalaList();
                openModal('modal-form-pertanyaan');
            });

            // Handle tipe pertanyaan change
            document.getElementById('tipe-pertanyaan').addEventListener('change', function() {
                const skalaContainer = document.getElementById('skala-container');
                if (this.value === 'pilihan_ganda' || this.value === 'skala') {
                    skalaContainer.classList.remove('hidden');
                } else {
                    skalaContainer.classList.add('hidden');
                    clearSkalaList();
                }
            });

            // Tambah skala
            document.getElementById('btn-tambah-skala').addEventListener('click', () => {
                addSkalaItem();
            });

            function clearSkalaList() {
                document.getElementById('skala-list').innerHTML = '';
            }

            function populateSkalaList(skalaArray) {
                clearSkalaList();
                skalaArray.forEach(item => addSkalaItem(item));
            }

            // Form pertanyaan submit
            document.getElementById('form-pertanyaan').addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                const submitBtn = document.getElementById('btn-submit-pertanyaan');
                const originalText = submitBtn.textContent;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Menyimpan...';

                try {
                    let url;
                    if (isEditMode) {
                        url = `/dashboard/kuesioner/pertanyaan/edit`;
                        formData.append('id', currentPertanyaanId);
                        formData.append('event_id', currentEventId);
                    } else {
                        url = `/dashboard/kuesioner/pertanyaan`;
                        formData.append('event_id', currentEventId);
                    }

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showNotification(isEditMode ? 'Pertanyaan berhasil diperbarui' :
                            'Pertanyaan berhasil ditambahkan');
                        closeModal('modal-form-pertanyaan');
                        loadPertanyaan(currentEventId);
                    } else {
                        throw new Error(data.message || 'Gagal menyimpan pertanyaan');
                    }
                } catch (error) {
                    console.error('Error saving pertanyaan:', error);
                    showNotification(error.message, 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });

            // Load pertanyaan for respon
            async function loadPertanyaanForRespon(eventId) {
                try {
                    const response = await fetch(`/dashboard/kuesioner/${eventId}/pertanyaan-list`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (!response.ok) throw new Error('Failed to load pertanyaan');

                    const pertanyaan = await response.json();
                    renderPertanyaanForRespon(pertanyaan.data);
                } catch (error) {
                    console.error('Error loading pertanyaan for respon:', error);
                    showNotification('Gagal memuat pertanyaan', 'error');
                }
            }

            // Render pertanyaan for respon
            function renderPertanyaanForRespon(pertanyaan) {
                const container = document.getElementById('pertanyaan-respon-container');

                if (!pertanyaan || pertanyaan.length === 0) {
                    container.innerHTML = '<p class="text-gray-500 text-center">Belum ada pertanyaan untuk kuesioner ini.</p>';
                    return;
                }

                container.innerHTML = pertanyaan.map((p, index) => {
                    let inputHtml = '';

                    switch (p.tipe) {
                        case 'esai':
                            inputHtml =
                                `<textarea name="jawaban[${p.id}]" class="w-full border rounded px-3 py-2" rows="3" required></textarea>`;
                            break;

                        case 'pilihan_ganda':
                            const pilihan = Array.isArray(p.skala) ? p.skala : JSON.parse(p.skala || '[]');
                            inputHtml = pilihan.map((option, i) => `
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="jawaban[${p.id}]" value="${option}" required>
                        <span>${option}</span>
                    </label>
                `).join('');
                            break;

                        case 'skala':
                            const skala = Array.isArray(p.skala) ? p.skala : JSON.parse(p.skala || '[]');
                            inputHtml = skala.map((option, i) => `
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="jawaban[${p.id}]" value="${option}" required>
                        <span>${option}</span>
                    </label>
                `).join('');
                            break;
                    }

                    return `
            <div class="mb-6 p-4 border rounded-lg">
                <label class="block text-sm font-medium mb-2">
                    ${index + 1}. ${p.pertanyaan}
                    <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2">
                    ${inputHtml}
                </div>
            </div>
        `;
                }).join('');
            }

            // Form respon submit
            document.getElementById('form-respon').addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                const submitBtn = document.getElementById('btn-submit-respon');
                const originalText = submitBtn.textContent;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim...';

                try {
                    const response = await fetch(`/dashboard/kuesioner/${currentEventId}/respon`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showNotification('Respon berhasil dikirim');
                        closeModal('modal-respon');

                        // Redirect to respon detail if available
                        if (data.respon_id) {
                            setTimeout(() => {
                                window.location.href =
                                    `/dashboard/kuesioner/${currentEventId}/respon/${data.respon_id}`;
                            }, 1000);
                        }
                    } else {
                        throw new Error(data.message || 'Gagal mengirim respon');
                    }
                } catch (error) {
                    console.error('Error submitting respon:', error);
                    showNotification(error.message, 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });

            // Add CSS for line-clamp
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

            // Initialize page
            document.addEventListener('DOMContentLoaded', () => {
                loadEvents();
            });
        </script>
    @endpush

@endsection
