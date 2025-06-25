@extends('layouts.Dashboard.dashboard')

@section('title', 'Manage Event - ALUMNET')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="min-h-screen flex flex-row bg-gradient-to-br from-blue-50 to-blue-100 text-gray-800">
    @include('layouts.Dashboard.sidebarkiri', [], ['class' => 'w-64 flex-shrink-0'])

    <div class="flex-1 p-8 ml-0 md:ml-64 transition-all duration-300">
        <!-- Header Section -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-4xl font-bold text-blue-700 mb-2">
                Manajemen Workshop & Event
            </h1>
            <p class="text-gray-600">Kelola workshop dan event pengembangan diri dengan mudah</p>
        </div>

        <!-- Notifications -->
        @if(session('success'))
        <div class="bg-green-500 text-white px-6 py-4 rounded-xl mb-6 shadow-lg animate-slide-down">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-500 text-white px-6 py-4 rounded-xl mb-6 shadow-lg animate-slide-down">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-500 text-white px-6 py-4 rounded-xl mb-6 shadow-lg animate-slide-down">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Quick Add Button -->
        <div class="mb-8 animate-fade-in-up">
            <button onclick="openForm('add')" class="group relative bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center space-x-3">
                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Tambah Event/Workshop Baru</span>
            </button>
        </div>

        <!-- Popup Form -->
        <div id="popupForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300">
            <div id="popupContent" class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl mx-4 relative transform scale-95 transition-transform duration-300">
                <!-- Header -->
                <div class="bg-blue-600 text-white p-6 rounded-t-2xl">
                    <div class="flex justify-between items-center">
                        <h2 id="popupTitle" class="text-2xl font-bold">Tambah Event/Workshop</h2>
                        <button onclick="closeForm()" class="text-white hover:text-red-300 transition-colors duration-200 p-2 hover:bg-white hover:bg-opacity-20 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8 max-h-96 overflow-y-auto">
                    <form id="mainForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <input type="hidden" name="event_id" id="event_id">

                        <!-- Event Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Tipe Event</label>
                            <select name="tipe_event" id="popup_tipe_event" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" required>
                                <option value="event">Workshop / Event</option>
                                <option value="loker">Loker</option>
                            </select>
                        </div>

                        <!-- Form Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Judul Event</label>
                                <input type="text" name="judul_event" id="popup_judul_event" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" required>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Dilaksanakan Oleh</label>
                                <input type="text" name="dilaksanakan_oleh" id="popup_dilaksanakan_oleh" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" required>
                            </div>

                            <div class="event-only space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="popup_tanggal_mulai" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            </div>

                            <div class="event-only space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Tanggal Akhir Pendaftaran</label>
                                <input type="date" name="tanggal_akhir_pendaftaran" id="popup_tanggal_akhir_pendaftaran" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            </div>

                            <div class="event-only space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" id="popup_waktu_mulai" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            </div>
                            <div class="event-only space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" id="popup_waktu_selesai" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            </div>

                            <div class="event-only space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Lokasi</label>
                                <input type="text" name="lokasi" id="popup_lokasi" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" placeholder="Offline/Zoom/Google Meet">
                            </div>



                            <div class="event-only space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Maksimal Peserta</label>
                                <input type="number" name="maksimal_peserta" id="popup_maksimal_peserta" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" min="0">
                            </div>

                            <div class="event-only space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Tools</label>
                                <input type="text" name="tools" id="popup_tools" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" placeholder="Contoh: VsCode, Excel, Zoom">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Link Event (opsional)</label>
                                <input type="url" name="link" id="popup_link" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            </div>

                            <div class="event-only space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Harga Daftar</label>
                                <input type="number" name="harga_daftar" id="popup_harga_daftar" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" min="0">
                            </div>
                            <div class="event-only space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Harga Diskon (opsional)</label>
                                <input type="number" name="harga_diskon" id="popup_harga_diskon" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" min="0">
                            </div>



                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Foto (opsional)</label>
                                <input type="file" name="foto" id="popup_foto" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" accept="image/*">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Status</label>
                                <select name="status" id="popup_status" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Event</label>
                            <textarea name="deskripsi_event" id="popup_deskripsi_event" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" rows="4"></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-6">
                            <button type="submit" id="popupSubmitBtn" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan</span>
                            </button>
                            <button type="button" onclick="closeForm()" class="flex-1 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-center px-6 py-3 rounded-xl font-semibold flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Batal</span>
                                <br>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up">
            <div class="bg-blue-600 text-white p-6">
                <h2 class="text-2xl font-bold flex items-center space-x-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Daftar Workshop & Event</span>
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Gambar</th> <!-- Tambah kolom gambar -->
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Tanggal Mulai</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Akhir Pendaftaran</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Penyelenggara</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Maks Peserta</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($workshops as $workshop)
                        <tr class="hover:bg-blue-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ $workshop->foto ? asset('images/events/' . $workshop->foto) : 'https://via.placeholder.com/60x40' }}" alt="Event Image" class="w-16 h-10 object-cover rounded">                                
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $workshop->judul_event }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($workshop->deskripsi_event, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $workshop->tanggal_mulai ? \Carbon\Carbon::parse($workshop->tanggal_mulai)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $workshop->tanggal_akhir_pendaftaran ? \Carbon\Carbon::parse($workshop->tanggal_akhir_pendaftaran)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $workshop->dilaksanakan_oleh }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($workshop->harga_daftar > 0)
                                <span class="text-green-600 font-semibold">Rp{{ number_format($workshop->harga_daftar,0,',','.') }}</span>
                                @else
                                <span class="text-blue-600 font-semibold">Gratis</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $workshop->maksimal_peserta ?: 'Unlimited' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($workshop->status == 'aktif')
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-1" onclick='openForm("detail", @json($workshop))'>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>Detail</span>
                                    </button>
                                    <button type="button" class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-1" onclick='openForm("edit", @json($workshop))'>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span>Edit</span>
                                    </button>
                                    <form action="{{ route('dashboard.workshop.destroy', $workshop->id) }}" method="POST" onsubmit="return confirm('Yakin hapus workshop ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center space-y-4">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="text-gray-500">
                                        <p class="text-lg font-semibold">Belum ada data workshop</p>
                                        <p class="text-sm">Mulai dengan menambahkan workshop atau event baru</p>
                                    </div>
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

    @keyframes slide-down {
        from {
            opacity: 0;
            transform: translateY(-20px);
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

    .animate-slide-down {
        animation: slide-down 0.4s ease-out;
    }

    /* Custom scrollbar */
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #3b82f6;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #2563eb;
    }
</style>

<script>
    // Enhanced popup animations and functionality
    function togglePopupEventFields() {
        const tipe = document.getElementById('popup_tipe_event').value;
        const eventFields = document.querySelectorAll('#popupForm .event-only');

        eventFields.forEach(function(el) {
            if (tipe === 'event') {
                el.style.display = '';
                el.style.opacity = '0';
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transition = 'opacity 0.3s ease-in-out';
                }, 50);
            } else {
                el.style.opacity = '0';
                setTimeout(() => {
                    el.style.display = 'none';
                }, 300);
            }
        });
    }

    function openForm(mode, data = null) {
        const popup = document.getElementById('popupForm');
        const popupContent = document.getElementById('popupContent');
        const form = document.getElementById('mainForm');

        // Show popup with animation
        popup.classList.remove('hidden');
        setTimeout(() => {
            popup.classList.remove('opacity-0');
            popupContent.classList.remove('scale-95');
            popupContent.classList.add('scale-100');
        }, 10);

        // Reset form
        form.reset();
        document.getElementById('formMethod').value = 'POST';
        form.action = "{{ route('dashboard.workshop.store') }}";
        document.getElementById('popupTitle').innerText = 'Tambah Event/Workshop';
        document.getElementById('popupSubmitBtn').style.display = '';

        // Enable all form elements
        const formElements = document.querySelectorAll('#mainForm input, #mainForm textarea, #mainForm select');
        formElements.forEach(el => {
            el.removeAttribute('readonly');
            el.removeAttribute('disabled');
            el.classList.remove('bg-gray-100');
        });

        if (mode === 'edit' && data) {
            document.getElementById('popupTitle').innerText = 'Edit Event/Workshop';
            document.getElementById('formMethod').value = 'PUT';
            form.action = `/dashboard/workshop/${data.id}`;
            fillFormData(data);
        } else if (mode === 'detail' && data) {
            document.getElementById('popupTitle').innerText = 'Detail Event/Workshop';
            document.getElementById('popupSubmitBtn').style.display = 'none';
            fillFormData(data);

            // Disable form elements for detail view
            formElements.forEach(el => {
                el.setAttribute('readonly', 'readonly');
                el.setAttribute('disabled', 'disabled');
                el.classList.add('bg-gray-100');
            });
        }

        togglePopupEventFields();
    }

    function fillFormData(data) {
        document.getElementById('popup_tipe_event').value = data.tipe_event || '';
        document.getElementById('popup_judul_event').value = data.judul_event || '';
        document.getElementById('popup_dilaksanakan_oleh').value = data.dilaksanakan_oleh || '';
        document.getElementById('popup_tanggal_mulai').value = data.tanggal_mulai || '';
        document.getElementById('popup_tanggal_akhir_pendaftaran').value = data.tanggal_akhir_pendaftaran || '';
        document.getElementById('popup_harga_daftar').value = data.harga_daftar || '';
        document.getElementById('popup_maksimal_peserta').value = data.maksimal_peserta || '';
        document.getElementById('popup_deskripsi_event').value = data.deskripsi_event || '';
        document.getElementById('popup_link').value = data.link || '';
        document.getElementById('popup_status').value = data.status || 'aktif';
        document.getElementById('popup_waktu_mulai').value = data.waktu_mulai ? data.waktu_mulai.substring(0, 5) : '';
        document.getElementById('popup_waktu_selesai').value = data.waktu_selesai ? data.waktu_selesai.substring(0, 5) : '';
        document.getElementById('popup_lokasi').value = data.lokasi || '';
        document.getElementById('popup_tools').value = data.tools || '';
        document.getElementById('popup_harga_diskon').value = data.harga_diskon || '';
    }

    function closeForm() {
        const popup = document.getElementById('popupForm');
        const popupContent = document.getElementById('popupContent');

        // Hide popup with animation
        popup.classList.add('opacity-0');
        popupContent.classList.remove('scale-100');
        popupContent.classList.add('scale-95');

        setTimeout(() => {
            popup.classList.add('hidden');
        }, 300);
    }

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('popup_tipe_event').addEventListener('change', togglePopupEventFields);
        togglePopupEventFields();

        // Close popup when clicking outside
        document.getElementById('popupForm').addEventListener('click', function(e) {
            if (e.target === this) {
                closeForm();
            }
        });

        // Add loading state to form submission
        document.getElementById('mainForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('popupSubmitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menyimpan...
                `;
            submitBtn.disabled = true;
        });
    });
</script>
@endsection