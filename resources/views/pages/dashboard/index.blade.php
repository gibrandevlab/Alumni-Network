@extends('layouts.Dashboard.dashboard')

@section('title', 'Admin - SITRA BSI')

@section('content')
    @if ($peranPengguna == 'admin')
        {{-- konten utama dari dashboard admin --}}
        <div
            class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased dark:bg-gray-700 text-black dark:text-white">
            {{-- menu admin --}}
            @include('layouts.Dashboard.navbaratas')
            @include('layouts.Dashboard.sidebarkiri')

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64">

                @include('components.dashboard.statistikangka', [
                    'jumlahPenggunaDisetujui' => $jumlahPenggunaDisetujui,
                ])

                <form method="GET" action="{{ route('dashboard.dashboard') }}" >
                    <div class="grid grid-cols-1 lg:grid-cols-2 p-4 gap-4">
                        @include('components.dashboard.responbyyears')
                        @include('components.dashboard.status')
                    </div>
                    <div class="grid grid-cols-1 p-4 gap-4">
                        @include('components.dashboard.statusallyear')
                    </div>
                    <div class="grid grid-cols-1 p-4 gap-4">
                        @include('components.dashboard.tablependidikan')
                    </div>
                </form>
            </div>
    @endif
@endsection
