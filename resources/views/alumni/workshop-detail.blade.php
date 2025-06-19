@extends('layouts.index')

@section('title', $workshop->judul_event . ' - Detail Workshop')

@section('content')
<div class="container py-8 min-h-screen">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8">
        <div class="mb-6">
            <a href="{{ route('alumni.workshop.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali ke daftar event</a>
        </div>
        <div class="mb-6">
            <img src="{{ $workshop->foto ? asset('storage/'.$workshop->foto) : 'https://via.placeholder.com/600x300' }}" class="w-full h-56 object-cover rounded-xl mb-4" alt="Event Image">
            <h1 class="text-3xl font-bold text-blue-700 mb-2">{{ $workshop->judul_event }}</h1>
            <div class="text-gray-500 mb-2">Diselenggarakan oleh <span class="font-semibold text-gray-800">{{ $workshop->dilaksanakan_oleh }}</span></div>
            <div class="flex flex-wrap gap-4 mb-4 text-sm">
                <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">Tanggal Mulai: <b>{{ $workshop->tanggal_mulai ? \Carbon\Carbon::parse($workshop->tanggal_mulai)->format('d M Y') : '-' }}</b></div>
                <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">Akhir Pendaftaran: <b>{{ $workshop->tanggal_akhir_pendaftaran ? \Carbon\Carbon::parse($workshop->tanggal_akhir_pendaftaran)->format('d M Y') : '-' }}</b></div>
                <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">Maksimal Peserta: <b>{{ $workshop->maksimal_peserta ?: 'Unlimited' }}</b></div>
            </div>
            <div class="mb-4">
                <span class="text-lg font-bold {{ $workshop->harga_daftar > 0 ? 'text-green-600' : 'text-blue-600' }}">
                    {{ $workshop->harga_daftar > 0 ? 'Rp'.number_format($workshop->harga_daftar,0,',','.') : 'Gratis' }}
                </span>
            </div>
            <div class="mb-6 text-gray-700 leading-relaxed">
                {!! nl2br(e($workshop->deskripsi_event)) !!}
            </div>
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
                <button id="btnDaftarEvent" class="inline-block px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition">Daftar</button>
            @elseif($pendaftaran && $pendaftaran->status === 'menunggu' && $statusPembayaran !== 'settlement')
                <button id="btnLihatPembayaran" class="inline-block px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-semibold transition">Lihat Pembayaran</button>
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
                <span class="inline-block px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold transition cursor-not-allowed opacity-80">Sudah Bayar</span>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tailwind -->
<div id="modalPembayaran" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">&times;</button>
        <h2 class="text-xl font-bold mb-4">Konfirmasi Pendaftaran & Pembayaran</h2>
        <form id="formPembayaran" class="space-y-4">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div>
                <label class="block font-semibold mb-1">Pilih Metode Pembayaran</label>
                <select name="metode_pembayaran" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">-- Pilih --</option>
                    <option value="gopay">Gopay</option>
                    <option value="bca">Virtual Account BCA</option>
                    <option value="bri">Virtual Account BRI</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">Konfirmasi & Dapatkan Kode Pembayaran</button>
        </form>
        <div id="hasilPembayaran" class="mt-6 hidden">
            <div class="font-semibold mb-2">Kode Pembayaran:</div>
            <div id="kodePembayaran" class="text-lg font-mono text-green-700 mb-2"></div>
            <div class="font-semibold mb-2">Nominal:</div>
            <div id="nominalPembayaran" class="text-lg text-blue-700 mb-2"></div>
            <div class="font-semibold mb-2">Metode:</div>
            <div id="metodePembayaran" class="text-lg text-gray-700 mb-2"></div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btnDaftarEvent')?.addEventListener('click', function() {
        document.getElementById('modalPembayaran').classList.remove('hidden');
    });
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('modalPembayaran').classList.add('hidden');
        document.getElementById('hasilPembayaran').classList.add('hidden');
        document.getElementById('formPembayaran').classList.remove('hidden');
    });
    document.getElementById('formPembayaran').addEventListener('submit', async function(e) {
        e.preventDefault();
        const metode = this.metode_pembayaran.value;
        if (!metode) return;
        const res = await fetch(`{{ route('alumni.workshop.daftar.ajax', $workshop->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this._token.value
            },
            body: JSON.stringify({ metode_pembayaran: metode })
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
</script>
@endsection
