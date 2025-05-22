@extends('layouts.Dashboard.dashboard')

@section('title', 'Admin - SITRA BSI')

@section('content')
    @if ($peranPengguna == 'admin')
        {{-- konten utama dari dashboard admin --}}
        <div
            class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased dark:bg-gray-300 text-black dark:text-white">
            {{-- menu admin --}}
            @include('layouts.Dashboard.navbaratas')
            @include('layouts.Dashboard.sidebarkiri')

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64">

                <div id="statistik-angka">
                    @include('components.dashboard.statistikangka', [
                        'jumlahPenggunaDisetujui' => $jumlahPenggunaDisetujui,
                        'jumlahPenggunaPending' => $jumlahPenggunaPending,
                        'persentaseRespondenKeseluruhan' => $persentaseRespondenKeseluruhan,
                    ])
                </div>

                <form method="GET" action="{{ route('dashboard.dashboard') }}" >
                    <div class="grid grid-cols-1 lg:grid-cols-2 p-4 gap-4">
                        <div class="card shadow-md p-4" id="respon-by-years">
                            @include('components.dashboard.responbyyears', [
                                'persentasePerTahun' => $persentasePerTahun,
                                'jurusandefault' => $jurusandefault
                            ])
                        </div>
                        <div class="card shadow-md p-4" id="status-tahun">
                            @include('components.dashboard.status', [
                                'jawabanKuesioner1' => $jawabanKuesioner1,
                                'jurusan1' => $jurusan1
                            ])
                        </div>
                    </div>
                    <div class="grid grid-cols-1 p-4 gap-4">
                        <div class="card shadow-md p-4" id="status-all-year">
                            @include('components.dashboard.statusallyear', [
                                'jawabanKuesioner2' => $jawabanKuesioner2,
                                'jurusan2' => $jurusan2
                            ])
                        </div>
                    </div>
                    <div class="grid grid-cols-1 p-4 gap-4">
                        <div class="card shadow-md p-4" id="table-pendidikan">
                            @include('components.dashboard.tablependidikan')
                        </div>
                    </div>
                </form>
            </div>
    @endif
@endsection
