@extends('layouts.index')
@section('content')
<div class="container py-4">
    <h2 class="text-2xl font-bold mb-4">Daftar Event Pengembangan Karir</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
        <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">
            <div>
                <img src="{{ $event->foto ? asset('storage/'.$event->foto) : 'https://via.placeholder.com/400x200' }}" class="w-full h-40 object-cover rounded mb-2" alt="Event Image">
                <h3 class="text-lg font-semibold">{{ $event->judul_event }}</h3>
                <p class="text-gray-600 text-sm mb-2">{{ $event->dilaksanakan_oleh }}</p>
                <p class="text-gray-700 mb-2">{{ $event->deskripsi_event }}</p>
                <p class="text-xs text-gray-500">Tanggal Mulai: {{ $event->tanggal_mulai }}</p>
                <p class="text-xs text-gray-500">Akhir Pendaftaran: {{ $event->tanggal_akhir_pendaftaran }}</p>
                <p class="text-xs text-gray-500">Harga: <span class="font-bold">{{ $event->harga_daftar > 0 ? 'Rp '.number_format($event->harga_daftar,0,',','.') : 'Gratis' }}</span></p>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('event.user.order', $event->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Daftar Sekarang</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
