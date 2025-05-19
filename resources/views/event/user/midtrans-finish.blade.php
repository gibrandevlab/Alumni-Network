@extends('layouts.index')
@section('content')
<div class="container py-4 max-w-lg mx-auto text-center">
    <h2 class="text-2xl font-bold mb-4 text-green-700">Pembayaran Berhasil!</h2>
    <p class="mb-4">Terima kasih, pembayaran Anda telah berhasil diproses.</p>
    <a href="{{ route('event.user.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Kembali ke Event</a>
</div>
@endsection
