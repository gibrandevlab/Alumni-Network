@extends('layouts.index')
@section('title', 'Isi Kuesioner: ' . $kuesioner->judul)
@section('content')
@php
$pertanyaan = $kuesioner->pertanyaan->sortBy('urutan')->values();
$total = $pertanyaan->count();
@endphp
<div class="max-w-2xl mx-auto px-2 sm:px-4 py-8">
    <a href="{{ url('/pengisian-tracer-study') }}" class="inline-block mb-4 text-[#2563EB] hover:text-[#1D4ED8] font-semibold text-base sm:text-lg transition">
        &larr; Kembali
    </a>
    <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 text-[#1E40AF]">{{ $kuesioner->judul }}</h1>
    <p class="text-gray-700 text-base sm:text-lg mb-4">{{ $kuesioner->deskripsi }}</p>
    <div class="border-b-2 border-gray-200 mb-6"></div>

    <!-- Progress Bar -->
    <div id="progress-bar" class="w-full bg-gray-200 rounded-full h-3 mb-8">
        <div id="progress-bar-inner" class="bg-[#2563EB] h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
    </div>

    <form method="POST" action="{{ route('kuesioner.submit', $kuesioner->id) }}" class="bg-white rounded-xl shadow p-4 sm:p-6" id="kuesionerForm">
        @csrf
        @foreach($pertanyaan as $idx => $p)
        <div class="mb-6">
            <div class="rounded-lg border border-gray-200 shadow-sm p-4 mb-2 bg-gray-50">
                <label class="block font-semibold text-gray-800 text-base sm:text-lg mb-3">{{ $p->urutan }}. {{ $p->pertanyaan }}</label>
                @if($p->tipe == 'likert')
                @php
                $opsi = preg_match('/^\d+\-\d+$/', $p->skala) ? range(...explode('-', $p->skala)) : explode(',', $p->skala);
                @endphp
                <div class="flex gap-3 flex-wrap">
                    @foreach($opsi as $opt)
                    <label class="inline-flex items-center gap-2 text-[#2563EB] text-base">
                        <input type="radio" name="jawaban[{{ $p->id }}]" value="{{ is_array($opt) ? $opt[0] : trim($opt) }}" required class="accent-[#2563EB] w-5 h-5">
                        <span>{{ is_array($opt) ? $opt[0] : trim($opt) }}</span>
                    </label>
                    @endforeach
                </div>
                @elseif($p->tipe == 'pilihan')
                @php $opsi = explode(',', $p->skala); @endphp
                <div class="flex gap-3 flex-wrap">
                    @foreach($opsi as $opt)
                    <label class="inline-flex items-center gap-2 text-[#2563EB] text-base">
                        <input type="radio" name="jawaban[{{ $p->id }}]" value="{{ trim($opt) }}" required class="accent-[#2563EB] w-5 h-5">
                        <span>{{ trim($opt) }}</span>
                    </label>
                    @endforeach
                </div>
                @else
                <textarea name="jawaban[{{ $p->id }}]" rows="2" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-[#2563EB] focus:border-[#2563EB] text-base"></textarea>
                @endif
            </div>
        </div>
        @endforeach
        <button type="submit" class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white font-bold px-4 py-2 rounded-lg shadow transition mt-4">Kirim Jawaban</button>
    </form>

    <!-- Modal Terima Kasih -->
    <div id="thanksModal" class="fixed inset-0 bg-black bg-opacity-40 items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center">
            <h2 class="text-2xl font-bold text-[#1E40AF] mb-2">Terima Kasih!</h2>
            <p class="text-gray-700 mb-4">Data Anda telah direkam.<br>Kami sangat menghargai partisipasi Anda.</p>
            <button onclick="window.location='{{ url('/') }}'" class="mt-2 bg-[#2563EB] hover:bg-[#1D4ED8] text-white font-semibold px-6 py-2 rounded-lg">Kembali ke Beranda</button>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var total = document.querySelectorAll('#kuesionerForm [name^="jawaban["]').length;
        const progressBar = document.getElementById('progress-bar-inner');

        function updateProgress() {
            let answered = 0;
            document.querySelectorAll('#kuesionerForm [name^="jawaban["]').forEach(function(el) {
                if ((el.type === 'radio' && el.checked) || (el.tagName === 'TEXTAREA' && el.value.trim() !== '')) {
                    answered++;
                }
            });
            const percent = (answered / total) * 100;
            progressBar.style.width = percent + '%';
        }
        document.getElementById('kuesionerForm').addEventListener('input', updateProgress);
        updateProgress();
        // Modal feedback setelah submit
        const form = document.getElementById('kuesionerForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const modal = document.getElementById('thanksModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => form.submit(), 1200);
        });
    });
</script>
@endpush