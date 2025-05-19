@extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tiket Event</h1>
    <div class="bg-white rounded shadow p-4 mb-4">
        <h2 class="font-semibold text-lg">{{ $event->judul_event }}</h2>
        <p>Nama: {{ $pendaftaran->user->nama ?? '-' }}</p>
        <p>No. Booking: <span class="font-mono">EVT-{{ $pendaftaran->id }}</span></p>
        <p>Event: {{ $event->judul_event }}</p>
        <p>Tanggal: {{ $event->tanggal_mulai }}</p>
        <p>Status: <span class="font-bold">{{ $pendaftaran->status }}</span></p>
        <hr class="my-2">
        <a href="javascript:window.print()" class="btn btn-primary">Cetak Tiket</a>
    </div>
    <a href="{{ route('alumni.events.index') }}" class="btn btn-secondary">Kembali ke Daftar Event</a>
</div>
@endsection
