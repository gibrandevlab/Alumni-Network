@extends('layouts.index')
@section('content')
<div class="container max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Kuesioner: {{ $event->judul_event }}</h2>
    <form method="POST" action="{{ route('kuesioner.submit', ['event_id' => $event->id]) }}">
        @csrf
        <input type="hidden" name="step" value="kategori">
        <div class="mb-6">
            <div class="font-semibold mb-2">Kategori: <span class="capitalize">{{ $kategori }}</span></div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 100%"></div>
            </div>
            <span class="text-xs">Langkah 2/2</span>
        </div>
        <h3 class="font-semibold mb-2">Pertanyaan Skala (Likert)</h3>
        @foreach($likert as $q)
        @php
            $opsi = is_array($q->skala) ? $q->skala : json_decode($q->skala, true);
        @endphp
        <div class="mb-4">
            <label class="block mb-1">{{ $q->pertanyaan }}</label>
            <div class="flex gap-2 flex-col md:flex-row">
                @foreach($opsi as $opt)
                <label class="inline-flex items-center">
                    <input type="radio" name="likert[P{{ $q->urutan }}]" value="{{ is_array($opt) ? $opt['value'] : $opt }}" required
                        @if(isset($jawaban[$kategori]['likert']) && isset($jawaban[$kategori]['likert']['P'.$q->urutan]) && $jawaban[$kategori]['likert']['P'.$q->urutan] == (is_array($opt) ? $opt['value'] : $opt)) checked @endif
                        @if(isset($isAdminApproved) && $isAdminApproved) disabled @endif>
                    <span class="ml-1">{{ is_array($opt) ? $opt['label'] : $opt }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
        <h3 class="font-semibold mb-2 mt-6">Pertanyaan Esai</h3>
        @foreach($esai as $q)
        <div class="mb-4">
            <label class="block mb-1">{{ $q->pertanyaan }}</label>
            <textarea name="esai[P{{ $q->urutan }}]" class="form-textarea w-full" rows="2" required @if(isset($isAdminApproved) && $isAdminApproved) disabled @endif>@if(isset($jawaban[$kategori]['esai']) && isset($jawaban[$kategori]['esai']['P'.$q->urutan])){{ $jawaban[$kategori]['esai']['P'.$q->urutan] }}@endif</textarea>
        </div>
        @endforeach
        <button class="btn btn-primary mt-4 w-full" @if(isset($isAdminApproved) && $isAdminApproved) disabled @endif>Kirim Jawaban</button>
    </form>
</div>
@endsection
