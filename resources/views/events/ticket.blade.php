@extends('layouts.index')

@section('content')
<div class="container max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Detail Event</h1>
    <div class="bg-white rounded shadow p-4 mb-4">
        <h2 class="font-semibold text-lg">{{ $event->judul_event }}</h2>
        <p class="text-gray-600">{{ $event->deskripsi_event }}</p>
        <p class="mt-2">Jadwal: {{ $event->tanggal_mulai }} - {{ $event->tanggal_akhir_pendaftaran }}</p>
        <p>Slot Maksimal: {{ $event->slot_max }}</p>
        <p class="font-bold mt-2">
            @if($event->harga_daftar == 0)
                Gratis
            @else
                Rp{{ number_format($event->harga_daftar, 0, ',', '.') }}
            @endif
        </p>
    </div>

    @if($event->harga_daftar == 0 && $pendaftaran && $pendaftaran->status == 'berhasil')
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">Pendaftaran Berhasil!</div>
        <a href="{{ route('alumni.events.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('alumni.events.ticket.download', [$event->id, $pendaftaran->id]) }}" class="btn btn-success ml-2">Lihat Tiket</a>
    @else
        @if($pendaftaran && $pendaftaran->status == 'berhasil' && request('status') == 'success')
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">Pendaftaran & Pembayaran Berhasil!</div>
            <a href="{{ route('alumni.events.ticket.download', [$event->id, $pendaftaran->id]) }}" class="btn btn-success">Download Tiket</a>
        @elseif($pendaftaran && $pendaftaran->status == 'menunggu')
            <button id="pay-btn" class="btn btn-primary">Bayar Sekarang</button>
            <div id="pay-error" class="text-red-600 mt-2 hidden"></div>
            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
            <script>
                document.getElementById('pay-btn').onclick = function() {
                    fetch("{{ route('payments.snap') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ pendaftaran_event_id: {{ $pendaftaran->id }} })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.snap_token) {
                            window.snap.pay(data.snap_token, {
                                onSuccess: function() {
                                    window.location.href = `{{ route('alumni.events.ticket', [$event->id]) }}?status=success`;
                                },
                                onPending: function() {
                                    alert('Pembayaran masih diproses.');
                                },
                                onError: function() {
                                    document.getElementById('pay-error').innerText = 'Pembayaran gagal.';
                                    document.getElementById('pay-error').classList.remove('hidden');
                                }
                            });
                        } else {
                            document.getElementById('pay-error').innerText = data.error || 'Gagal mendapatkan token pembayaran.';
                            document.getElementById('pay-error').classList.remove('hidden');
                        }
                    })
                    .catch(() => {
                        document.getElementById('pay-error').innerText = 'Terjadi kesalahan.';
                        document.getElementById('pay-error').classList.remove('hidden');
                    });
                }
            </script>
        @endif
        <a href="{{ route('alumni.events.index') }}" class="btn btn-secondary mt-4">Kembali</a>
    @endif
</div>
@endsection
