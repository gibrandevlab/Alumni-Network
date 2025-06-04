@extends('layouts.index')
@section('content')
<div class="container max-w-xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Kuesioner: {{ $event->judul_event }}</h2>
    <form method="POST" action="{{ route('kuesioner.submit', ['event_id' => $event->id]) }}">
        @csrf
        <input type="hidden" name="step" value="umum">
        <div class="mb-4">
            <label class="block font-semibold mb-2">{{ $pertanyaan->pertanyaan }}</label>
            @foreach(json_decode($pertanyaan->skala) as $opt)
            <div>
                <input type="radio" name="P1" value="{{ $opt }}" id="opt-{{ $loop->index }}" required {{ (isset($jawaban['umum']['P1']) && $jawaban['umum']['P1'] == $opt) ? 'checked' : '' }} @if(isset($isAdminApproved) && $isAdminApproved) disabled @endif>
                <label for="opt-{{ $loop->index }}">{{ $opt }}</label>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between items-center">
            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 33%"></div>
            </div>
            <span class="text-xs">Langkah 1/2</span>
        </div>
        <button class="btn btn-primary mt-4 w-full" @if(isset($isAdminApproved) && $isAdminApproved) disabled @endif>Lanjut</button>
    </form>
</div>
@endsection
