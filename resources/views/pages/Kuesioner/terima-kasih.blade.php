@extends('layouts.index')
@section('content')
<div class="container max-w-lg mx-auto text-center py-16">
    <div class="bg-white rounded shadow p-8">
        <h2 class="text-2xl font-bold mb-4 text-green-600">Terima Kasih!</h2>
        <p class="mb-4">Jawaban Anda untuk event <b>{{ $event->judul_event }}</b> telah berhasil disimpan.<br>Partisipasi Anda sangat berarti untuk pengembangan kampus dan alumni.</p>
        <a href="/" class="btn btn-primary mt-4">Kembali ke Beranda</a>
    </div>
</div>
@endsection
