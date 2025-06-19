@extends('layouts.index')

@section('title', 'Pembayaran Event - ' . $event->judul_event)

@section('content')
<div class="container py-8 min-h-screen">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-blue-700 mb-4">Pembayaran Event</h1>
        <div class="mb-4">
            <div class="font-semibold">Event:</div>
            <div>{{ $event->judul_event }}</div>
            <div class="font-semibold mt-2">Nominal:</div>
            <div class="text-green-600 text-lg font-bold">Rp{{ number_format($event->harga_daftar,0,',','.') }}</div>
        </div>
        <form action="{{ route('alumni.workshop.bayar.proses', $event->id) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">Lanjut ke Pembayaran (Simulasi)</button>
        </form>
    </div>
</div>
@endsection
