@extends('layouts.index')
@section('content')
<div class="container py-4 max-w-lg mx-auto text-center">
    <h2 class="text-2xl font-bold mb-4 text-yellow-600">Pembayaran Belum Selesai</h2>
    <p class="mb-4">Transaksi Anda belum selesai. Silakan selesaikan pembayaran atau ulangi prosesnya.</p>
    <a href="{{ route('event.user.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Kembali ke Event</a>
</div>
@endsection
