@if(session('success'))
<div id="successModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/3">
        <h3 class="text-xl font-semibold text-green-600">Pendaftaran Berhasil</h3>
        <p>{{ session('success') }}</p>
        <div class="mt-4 flex justify-end">
            <button onclick="closeModal()" class="bg-blue-500 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
</div>

<script>
    // Tampilkan modal jika ada pesan sukses
    window.onload = function() {
        var modal = document.getElementById('successModal');
        modal.style.display = 'flex';
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        var modal = document.getElementById('successModal');
        modal.style.display = 'none';
    }
</script>
@endif

<div class="w-full px-4 lg:px-0 my-24 py-12 flex items-center justify-center flex-col bg-gray-100" id="event">
    <h1 class="text-3xl font-bold mb-6 text-[#003194]">Event Pengembangan Karir</h1>
    <div class="container mx-auto flex flex-col lg:flex-row justify-between items-start gap-6 h-auto rounded-lg">
        <div id="event-content" class="w-full lg:w-2/3 p-6 flex flex-col gap-6 rounded-lg">
            <h2 class="text-2xl font-bold">Event Terbaru</h2>

            <!-- Display first 3 events -->
            @foreach ($events->take(3) as $event)
                <div
                    class="flex flex-col sm:flex-row w-full bg-white shadow-lg p-6 mb-6 rounded-[25px_0_25px_0] overflow-hidden animate-fade-in-up">
                    <div
                        class="w-full sm:w-1/4 aspect-square mb-4 sm:mb-0 transition-transform duration-300 hover:scale-105">
                        <img src="{{ asset('storage/' . $event->foto) }}" alt="Foto Acara"
                            class="object-cover w-full h-full rounded-lg">
                    </div>
                    <div class="w-full sm:w-2/4 flex flex-col gap-4 px-4">
                        <h3 class="text-xl font-bold text-gray-800 animate-fade-in" style="animation-delay: 0.2s;">
                            {{ $event->judul_event }}</h3>
                        <p class="text-sm text-gray-600 animate-fade-in" style="animation-delay: 0.3s;">
                            {{ $event->deskripsi_event }}</p>
                        <p class="text-xs text-gray-500 animate-fade-in" style="animation-delay: 0.4s;">
                            {{ $event->dilaksanakan_oleh }}</p>
                        <p class="text-xs animate-fade-in" style="animation-delay: 0.5s;">
                            <span class="text-red-500">Acara berakhir pada
                                {{ date('d-m-Y', strtotime($event->tanggal_akhir)) }}</span>
                        </p>
                        <div>
                            <a href="{{ $event->link == 'dashboard/event/mendaftar?event=' . $event->id ? $event->link : 'dashboard/event/mendaftar?event=' . $event->id }}"
                               class="inline-block bg-blue-600 text-white font-semibold py-2 px-4 rounded-full hover:bg-blue-700 transition-colors duration-200 animate-fade-in-up"
                               style="animation-delay: 0.6s;">
                                Lihat Detail
                            </a>
                        </div>






                    </div>
                    <div
                        class="w-full sm:w-1/4 aspect-square mt-4 sm:mt-0 transition-transform duration-300 hover:scale-105">
                        <img src="{{ asset('storage/images/events/qr/' . $event->link . '.png') }}" alt="QR Code"
                            class="object-contain w-full h-full">
                    </div>
                </div>
            @endforeach

            <!-- Additional events (hidden initially) -->
            <div id="additional-cards" class="hidden">
                @foreach ($events->skip(3)->take(5) as $event)
                    <div class="flex w-full bg-white shadow-md p-4 mb-4"
                        style="border-radius: 25px 0 25px 0; box-shadow: 0 0 10px 0 rgb(0 49 148 / 20%);">
                        <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                            <img src="{{ asset('storage/' . $event->foto) }}" alt="Foto Acara"
                                class="object-cover w-full h-full rounded-lg">
                        </div>
                        <div class="w-2/4 flex flex-col gap-4 px-4">
                            <h3 class="text-lg font-bold">{{ $event->judul_event }}</h3>
                            <p class="text-sm text-gray-600">{{ $event->deskripsi_event }}</p>
                            <p class="text-xs">{{ $event->dilaksanakan_oleh }}</p>
                            <p class="text-xs"><span class="text-red-500">Acara berakhir pada
                                    {{ date('d-m-Y', strtotime($event->tanggal_akhir)) }}</span></p>
                        </div>
                        <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                            <img src="{{ asset('storage/images/events/qr/' . $event->link . '.png') }}" alt="QR Code" class="object-contain w-full h-full">
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($events->count() > 3)
                <button id="see-all" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    See All
                </button>
                <button id="minimize-all"
                    class="mt-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 hidden">
                    Minimize
                </button>
            @endif
        </div>
        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.5s ease-out forwards;
            }

            .animate-fade-in {
                animation: fadeIn 0.5s ease-out forwards;
            }
        </style>
        <div id="loker" class="w-full lg:w-1/3 p-6 p-6 flex flex-col gap-6 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Loker</h2>

            <!-- Display first 3 job listings -->
            @foreach ($loker->take(3) as $lokerItem)
                <div class="flex w-full bg-white p-4 mb-4"
                    style="border-radius: 25px 0 25px 0; box-shadow: 0 0 10px 0 rgb(0 49 148 / 20%);">
                    <div class="w-full sm:w-2/4 lg:w-2/4 aspect-square">
                        <img src="{{ asset('storage/images/events/qr/' . $lokerItem->link . '.png') }}" alt="QR"
                            class="object-cover w-full h-full rounded-lg">
                    </div>
                    <div class="w-2/4 flex flex-col px-4">
                        <h3 class="text-lg font-bold">{{ $lokerItem->judul_event }}</h3>
                        <p class="text-sm line-clamp-3">{{ substr($lokerItem->deskripsi_event, 0, 100) }}</p>
                        <p class="text-xs">Posted by {{ $lokerItem->dilaksanakan_oleh }}</p>
                    </div>
                </div>
            @endforeach

            <!-- Additional job listings (hidden initially) -->
            <div id="additional-loker" class="hidden">
                @foreach ($loker->skip(3)->take(5) as $lokerItem)
                    <div class="flex w-full bg-white p-4 mb-4"
                        style="border-radius: 25px 0 25px 0; box-shadow: 0 0 10px 0 rgb(0 49 148 / 20%);">
                        <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                            <img src="{{ asset('storage/images/events/qr/' . $event->link . '.png') }}" alt="Loker Photo"
                                class="object-cover w-full h-full rounded-lg">
                        </div>
                        <div class="w-2/4 flex flex-col px-4">
                            <h3 class="text-lg font-bold">{{ $lokerItem->judul_event }}</h3>
                            <p class="text-sm line-clamp-3">{{ $lokerItem->deskripsi_event }}</p>
                            <p class="text-xs">Posted by {{ $lokerItem->dilaksanakan_oleh }}</p>
                        </div>
                        <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                            <canvas id="qrcode{{ $lokerItem->id }}"></canvas>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($loker->count() > 3)
                <button id="see-all-loker" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    See All
                </button>
                <button id="minimize-all-loker"
                    class="mt-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 hidden">
                    Minimize
                </button>
            @endif
        </div>
    </div>
</div>
