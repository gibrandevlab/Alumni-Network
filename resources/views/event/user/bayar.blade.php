@extends('layouts.index')
@section('content')
<div class="container py-4 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Pembayaran Event</h2>
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-2">{{ $event->judul_event }}</h3>
        <p class="mb-2">Total Bayar: <span class="font-bold">Rp {{ number_format($event->harga_daftar,0,',','.') }}</span></p>
        <div id="snap-container"></div>
        <button id="pay-button" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full mt-4">Bayar Sekarang</button>
    </div>
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    // Ikuti dokumentasi Snap JS Midtrans
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function (e) {
        e.preventDefault();
        window.snap.pay(@json($snapToken), {
            onSuccess: function(result) {
                // Redirect ke halaman finish Midtrans
                window.location.href = "{{ route('midtrans.finish') }}?order_id=" + result.order_id;
            },
            onPending: function(result) {
                // Redirect ke halaman unfinish Midtrans
                window.location.href = "{{ route('midtrans.unfinish') }}?order_id=" + result.order_id;
            },
            onError: function(result) {
                // Redirect ke halaman error Midtrans
                window.location.href = "{{ route('midtrans.error') }}?order_id=" + result.order_id;
            },
            onClose: function() {
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection
