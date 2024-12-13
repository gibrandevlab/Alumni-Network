<div class="flex justify-end mb-4">
    <button onclick="showCreateModal()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-700">Tambah
        Event</button>
</div>
<h2 class="text-2xl font-semibold mb-4 dark:bg-gray-800 dark:text-white">Data Events</h2>

<!-- Search Form -->
<form id="searchForm" method="GET" action="{{ route('dashboard.events.index') }}" class="flex items-center mb-4">
    <div class="bg-white rounded flex items-center w-full max-w-xl mr-4 p-2 shadow-sm border border-gray-200">
        <button type="button" class="outline-none focus:outline-none" id="searchButton">
            <svg class="w-5 text-white h-5 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
        <input type="search" name="search" id="searchInput" placeholder="Search"
            class="w-full pl-3 text-sm text-white outline-none focus:outline-none bg-transparent"
            value="{{ request()->input('search') }}">
    </div>
</form>

<!-- Event Table -->
<table class="min-w-full leading-normal">
    <thead>
        <tr>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-white text-left text-sm uppercase font-semibold">No
            </th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-white text-left text-sm uppercase font-semibold">
                Judul</th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-white text-left text-sm uppercase font-semibold">
                Sisa Waktu</th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-white text-left text-sm uppercase font-semibold">
                Dilaksanakan Oleh</th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-white text-left text-sm uppercase font-semibold">Foto
            </th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-white text-left text-sm uppercase font-semibold">QR
                Code</th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-white text-left text-sm uppercase font-semibold">Aksi
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($event as $item)
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                data-id="{{ $item->id }}">
                <td class="px-5 py-4 border-b border-gray-200 text-white">
                    {{ ($event->currentPage() - 1) * $event->perPage() + $loop->iteration }}</td>
                <td class="px-5 py-4 border-b border-gray-200 text-white">{{ $item->judul_event }}</td>
                <td class="px-5 py-4 border-b border-gray-200 text-white"><span
                        id="countdown-{{ $item->id }}"></span></td>
                <td class="px-5 py-4 border-b border-gray-200 text-white">{{ $item->dilaksanakan_oleh }}</td>
                <td class="px-5 py-4 border-b border-gray-200 text-white">
                    <button onclick="toggleImage('foto-{{ $item->id }}')" class="text-blue-500 hover:text-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </button>
                    <img id="foto-{{ $item->id }}" src="{{ asset('storage/' . $item->foto) }}" alt="Foto Event"
                        width="100" class="hidden mt-2">
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-white">
                    <button onclick="toggleImage('qr-{{ $item->id }}')" class="text-blue-500 hover:text-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0a2 2 0 110-4h-1.586a1 1 0 01-.707.293l-1.414 1.414a1 1 0 01-1.414-1.414zm-8 0a2 2 0 110-4h-1.586a1 1 0 00-.707.293L1 16.586V7a1 1 0 011-1h10a1 1 0 011 1v10.586l-4.293-4.293zm3.293 1.707a1 1 0 011.414 1.414L15.414 20l1.293-1.293a1 1 0 012 0zM5 16a1 1 0 011-1h2a1 1 0 110 2H6a1 1 0 01-1-1z">
                            </path>
                        </svg>
                    </button>
                    <img id="qr-{{ $item->id }}" src="{{ asset('storage/images/events/qr' . $item->link . '.png') }}" alt="QR Code"
                        width="100" class="hidden mt-2">
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-white space-x-2">
                    <button onclick="showDetail({{ $item->id }})" class="text-blue-500 hover:text-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </button>
                    <button onclick="showEditModal({{ $item->id }})" class="text-yellow-500 hover:text-yellow-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </button>
                    <form action="{{ route('dashboard.events.destroy', ['event' => $item->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="mt-4">
    {{ $event->links() }}
</div>

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="hidden fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm shadow-xl">
    <div class="dark:bg-gray-800 p-8 rounded-lg text-center max-w-sm w-full">
        <h2 class="text-lg font-semibold mb-6 text-white">Anda yakin ingin menghapus data ini?</h2>
        <div class="flex justify-center gap-6">
            <button id="confirmDeleteBtn"
                class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">Hapus</button>
            <button id="cancelDeleteBtn"
                class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Batal</button>
        </div>
    </div>
</div>
<div id="imageModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-75"
    onclick="closeImageModal()">
    <img id="modalImage" class="max-w-full max-h-full mx-auto" alt="Preview">
</div>

<script>
    // Mengambil tanggal akhir dari server-side (Blade)
    const endDate = new Date("{{ $item->tanggal_akhir }}").getTime();

    // Fungsi untuk memperbarui hitungan mundur
    function updateCountdown() {
        const now = new Date().getTime(); // Waktu saat ini
        const distance = endDate - now; // Selisih waktu

        if (distance <= 0) {
            document.getElementById("countdown-{{ $item->id }}").innerHTML = "Waktu Habis";
            clearInterval(intervalId);
            return;
        }

        // Hitung waktu dalam hari, jam, menit, dan detik
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Format output
        document.getElementById("countdown-{{ $item->id }}").innerHTML =
            `${days}:${hours}:${minutes}:${seconds}`;
    }

    // Jalankan fungsi setiap detik
    const intervalId = setInterval(updateCountdown, 1000);

    // Panggil sekali agar langsung terlihat
    updateCountdown();

    function toggleImage(id) {
        const imgElement = document.getElementById(id);
        const modal = document.getElementById("imageModal");
        const modalImage = document.getElementById("modalImage");

        if (imgElement && modal && modalImage) {
            modalImage.src = imgElement.src;
            modal.classList.remove("hidden");
        }
    }

    function closeImageModal() {
        const modal = document.getElementById("imageModal");
        modal.classList.add("hidden");
        const modalImage = document.getElementById("modalImage");
        modalImage.src = "";
    }
</script>

