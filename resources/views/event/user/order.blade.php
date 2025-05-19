@extends('layouts.index')
@section('content')
<div class="container py-4 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Order Tiket Event</h2>
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-2">{{ $event->judul_event }}</h3>
        <p class="mb-2">{{ $event->deskripsi_event }}</p>
        <p class="text-sm text-gray-600 mb-2">Tanggal Mulai: {{ $event->tanggal_mulai }}</p>
        <p class="text-sm text-gray-600 mb-2">Harga: <span class="font-bold">{{ $event->harga_daftar > 0 ? 'Rp '.number_format($event->harga_daftar,0,',','.') : 'Gratis' }}</span></p>
        <form action="{{ route('event.user.daftar', $event->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full mt-4">@if($event->harga_daftar > 0) Lanjut ke Pembayaran @else Daftar Sekarang @endif</button>
        </form>
    </div>
</div>
@endsection
