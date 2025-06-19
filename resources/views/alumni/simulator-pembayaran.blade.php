@extends('layouts.index')

@section('title', 'Simulator Pembayaran Event')

@section('content')
<div class="container py-8 min-h-screen">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-blue-700 mb-4">Simulator Pembayaran</h1>
        <form action="{{ route('alumni.simulator.proses') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold mb-1">Kode Pembayaran (Gopay/VA)</label>
                <input type="text" name="kode_pembayaran" class="w-full border rounded-lg px-3 py-2" placeholder="Masukkan kode pembayaran (misal: GPY86254979, BCAxxxx, BRIxxxx)" required>
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl transition">Simulasikan Pembayaran</button>
        </form>
    </div>
</div>
@endsection
