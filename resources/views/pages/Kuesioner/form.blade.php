@extends('layouts.index')
@section('title', 'Isi Kuesioner: ' . $kuesioner->judul)
@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <h1 class="text-xl font-bold text-gray-800 mb-2">{{ $kuesioner->judul }}</h1>
    <p class="text-gray-600 mb-6">{{ $kuesioner->deskripsi }}</p>
    <form method="POST" action="{{ route('kuesioner.submit', $kuesioner->id) }}" class="bg-white rounded-lg shadow p-6">
        @csrf
        @foreach($kuesioner->pertanyaan->sortBy('urutan') as $p)
        <div class="mb-6">
            <label class="block font-semibold text-gray-700 mb-2">{{ $p->urutan }}. {{ $p->pertanyaan }}</label>
            @if($p->tipe == 'likert')
                @php
                    $opsi = preg_match('/^\d+\-\d+$/', $p->skala) ? range(...explode('-', $p->skala)) : explode(',', $p->skala);
                @endphp
                <div class="flex gap-3 flex-wrap">
                    @foreach($opsi as $opt)
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" name="jawaban[{{ $p->id }}]" value="{{ is_array($opt) ? $opt[0] : trim($opt) }}" required>
                        <span>{{ is_array($opt) ? $opt[0] : trim($opt) }}</span>
                    </label>
                    @endforeach
                </div>
            @elseif($p->tipe == 'pilihan')
                @php $opsi = explode(',', $p->skala); @endphp
                <div class="flex gap-3 flex-wrap">
                    @foreach($opsi as $opt)
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" name="jawaban[{{ $p->id }}]" value="{{ trim($opt) }}" required>
                        <span>{{ trim($opt) }}</span>
                    </label>
                    @endforeach
                </div>
            @else
                <textarea name="jawaban[{{ $p->id }}]" rows="2" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500"></textarea>
            @endif
        </div>
        @endforeach
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">Kirim Jawaban</button>
    </form>
</div>
@endsection 