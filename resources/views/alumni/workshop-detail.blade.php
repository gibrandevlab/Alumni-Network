@extends('layouts.index')

@section('title', $workshop->judul_event . ' - Detail Workshop')

@section('content')
<div class="container py-8 min-h-screen">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Kiri: Konten utama -->
        <div class="md:col-span-2">
            <h1 class="text-3xl md:text-4xl font-bold text-blue-700 mb-4">{{ $workshop->judul_event }}</h1>
            <img src="{{ $workshop->foto ? asset('storage/'.$workshop->foto) : 'https://via.placeholder.com/600x300' }}" class="w-full h-64 object-cover rounded-xl mb-6" alt="Event Image">
            <div class="mb-6 border border-blue-100 rounded-xl p-6 bg-blue-50/40">
                <h2 class="text-lg font-semibold text-blue-700 mb-2">Deskripsi Event</h2>
                <div class="text-gray-700 leading-relaxed">{!! nl2br(e($workshop->deskripsi_event)) !!}</div>
            </div>
        </div>
        <!-- Kanan: Sidebar info & aksi -->
        <div class="md:col-span-1">
            <div class="border border-blue-200 rounded-2xl p-6 bg-white shadow-md mb-6">
                <div class="mb-2">
                    <span class="text-2xl font-bold text-blue-700 block">
                        @if($workshop->harga_daftar > 0)
                        Rp{{ number_format($workshop->harga_daftar,0,',','.') }}
                        @else
                        Gratis
                        @endif
                    </span>
                    @if($workshop->harga_diskon && $workshop->harga_diskon > 0)
                    <span class="text-gray-400 line-through text-lg">Rp{{ number_format($workshop->harga_diskon,0,',','.') }}</span>
                    @endif
                </div>
                <div class="mb-4">
                    @php
                    use Illuminate\Support\Facades\Auth;
                    $user = Auth::user();
                    $pendaftaran = null;
                    $statusPembayaran = null;
                    if ($user && $user->role === 'alumni') {
                    $pendaftaran = \App\Models\PendaftaranEvent::where('event_id', $workshop->id)->where('user_id', $user->id)->first();
                    if ($pendaftaran && $pendaftaran->pembayaran) {
                    $statusPembayaran = $pendaftaran->pembayaran->status_pembayaran;
                    }
                    }
                    @endphp
                    @if(!$pendaftaran && $user && $user->role === 'alumni')
                    <button id="btnDaftarEvent" class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition mb-2">Daftar Event</button>
                    @elseif($pendaftaran && $pendaftaran->status === 'menunggu' && $statusPembayaran !== 'settlement')
                    <button id="btnLihatPembayaran" class="w-full px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-semibold transition mb-2">Lihat Pembayaran</button>
                    <div id="infoPembayaran" class="mt-4 hidden">
                        <div class="font-semibold mb-1">Kode Pembayaran:</div>
                        <div class="text-lg font-mono text-green-700 mb-2">{{ $pendaftaran->kode_pembayaran }}</div>
                        <div class="font-semibold mb-1">Metode Pembayaran:</div>
                        <div class="text-lg text-gray-700 mb-2">{{ strtoupper($pendaftaran->metode_pembayaran) }}</div>
                        <div class="font-semibold mb-1">Nominal:</div>
                        <div class="text-lg text-blue-700 mb-2">Rp{{ number_format($workshop->harga_daftar,0,',','.') }}</div>
                    </div>
                    <script>
                        document.getElementById('btnLihatPembayaran')?.addEventListener('click', function() {
                            document.getElementById('infoPembayaran').classList.toggle('hidden');
                        });
                    </script>
                    @elseif($pendaftaran && $pendaftaran->status === 'berhasil' && $statusPembayaran === 'settlement')
                    <span class="inline-block w-full px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold transition cursor-not-allowed opacity-80 text-center mb-2">Sudah Bayar</span>
                    @endif
                </div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($workshop->dilaksanakan_oleh) }}&background=2563eb&color=fff&size=128" alt="{{ $workshop->dilaksanakan_oleh }}" class="w-10 h-10 object-cover">
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800 leading-tight">{{ $workshop->dilaksanakan_oleh }}</div>
                        <div class="text-xs text-gray-500">Penyelenggara</div>
                    </div>
                </div>
                <div class="border-t border-blue-100 pt-4">
                    <div class="mb-2 text-gray-700 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal:
                    </div>
                    <div class="ml-7 text-gray-600 mb-2">
                        {{ $workshop->tanggal_mulai ? \Carbon\Carbon::parse($workshop->tanggal_mulai)->format('d M Y') : '-' }}<br>
                        s/d {{ $workshop->tanggal_akhir_pendaftaran ? \Carbon\Carbon::parse($workshop->tanggal_akhir_pendaftaran)->format('d M Y') : '-' }}
                    </div>
                    <div class="mb-2 text-gray-700 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17v1a3 3 0 003 3h2a3 3 0 003-3v-1" />
                        </svg>
                        Waktu:
                    </div>
                    <div class="ml-7 text-gray-600 mb-2">
                        {{ $workshop->waktu_mulai ? \Carbon\Carbon::parse($workshop->waktu_mulai)->format('H:i') : '-' }} - {{ $workshop->waktu_selesai ? \Carbon\Carbon::parse($workshop->waktu_selesai)->format('H:i') : 'Selesai' }}
                    </div>
                    <div class="mb-2 text-gray-700 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a2 2 0 00-2.828 0l-4.243 4.243" />
                        </svg>
                        Lokasi:
                    </div>
                    <div class="ml-7 text-gray-600 mb-2">{{ $workshop->lokasi ?: '-' }}</div>
                    <div class="mb-2 text-gray-700 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 21m6-4l.75 4M9 21h6" />
                        </svg>
                        Tools:
                    </div>
                    <div class="ml-7 text-gray-600 mb-2">{{ $workshop->tools ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pembayaran -->
<div id="modalPembayaran" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-8 w-full max-w-md relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">&times;</button>
        <h2 class="text-xl font-bold mb-4">Pilih Metode Pembayaran</h2>
        <form id="formPembayaran">
            @csrf
            <div class="mb-4">
                <select name="metode_pembayaran" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="gopay">Gopay</option>
                    <option value="bca">BCA Virtual Account</option>
                    <option value="bri">BRI Virtual Account</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">Daftar & Dapatkan Kode Pembayaran</button>
        </form>
        <div id="hasilPembayaran" class="hidden mt-6">
            <div class="font-semibold mb-1">Kode Pembayaran:</div>
            <div id="kodePembayaran" class="text-lg font-mono text-green-700 mb-2"></div>
            <div class="font-semibold mb-1">Metode Pembayaran:</div>
            <div id="metodePembayaran" class="text-lg text-gray-700 mb-2"></div>
            <div class="font-semibold mb-1">Nominal:</div>
            <div id="nominalPembayaran" class="text-lg text-blue-700 mb-2"></div>
            <div class="mt-4 text-sm text-gray-500">Gunakan kode pembayaran ini untuk simulasi pembayaran.</div>
        </div>
    </div>
</div>

<!-- Script tetap -->
@stack('scripts')
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btnDaftarEvent')?.addEventListener('click', function() {
            document.getElementById('modalPembayaran').classList.remove('hidden');
        });
        document.getElementById('closeModal')?.addEventListener('click', function() {
            document.getElementById('modalPembayaran').classList.add('hidden');
            document.getElementById('hasilPembayaran').classList.add('hidden');
            document.getElementById('formPembayaran').classList.remove('hidden');
        });
        document.getElementById('formPembayaran')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const metode = this.metode_pembayaran.value;
            if (!metode) return;
            const res = await fetch(`{{ route('alumni.workshop.daftar.ajax', $workshop->id) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this._token.value
                },
                body: JSON.stringify({
                    metode_pembayaran: metode
                })
            });
            const data = await res.json();
            if (data.success) {
                document.getElementById('kodePembayaran').textContent = data.kode_pembayaran;
                document.getElementById('nominalPembayaran').textContent = 'Rp' + Number(data.nominal).toLocaleString('id-ID');
                document.getElementById('metodePembayaran').textContent = data.metode_pembayaran.toUpperCase();
                document.getElementById('hasilPembayaran').classList.remove('hidden');
                document.getElementById('formPembayaran').classList.add('hidden');
            }
        });
    });
</script>
@endpush
@endsection