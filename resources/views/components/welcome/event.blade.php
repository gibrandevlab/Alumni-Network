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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col">
            <img src="{{ asset('images/pelatihan/pelatihan1.jpg') }}" alt="Garmen Apparel" class="rounded-md h-40 object-cover mb-4">
            <div class="font-semibold text-sm text-gray-500 mb-1">Software Development</div>
            <div class="font-bold text-lg mb-2">Membuat Aplikasi Android dengan Flutter</div>
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Offline</span>
                <span class="text-xs text-gray-500">+ 1 Lainnya</span>
            </div>
            <div class="text-sm mb-2">Harga <span class="font-bold">Rp70.000 </span><s>Rp100.000</s></div>
            <a href="{{ url('/pelatihan/1') }}" class="bg-blue-600 text-white py-2 rounded mt-auto text-center">Ikuti Pelatihan</a>
            <div class="text-xs text-gray-400 mt-2">Pelatihan dari Dicoding </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col">
            <img src="{{ asset('images/pelatihan/pelatihan1.jpg') }}" alt="Garmen Apparel" class="rounded-md h-40 object-cover mb-4">
            <div class="font-semibold text-sm text-gray-500 mb-1">Software Development</div>
            <div class="font-bold text-lg mb-2">Membuat Aplikasi Android dengan Flutter</div>
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Online</span>
                <span class="text-xs text-gray-500">+ 1 Lainnya</span>
            </div>
            <div class="text-sm mb-2">Harga <span class="font-bold">Rp70.000 </span><s>Rp100.000</s></div>
            <button class="bg-blue-600 text-white py-2 rounded mt-auto">Ikuti Pelatihan</button>
            <div class="text-xs text-gray-400 mt-2">Pelatihan dari Dicoding </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col">
            <img src="{{ asset('images/pelatihan/pelatihan1.jpg') }}" alt="Garmen Apparel" class="rounded-md h-40 object-cover mb-4">
            <div class="font-semibold text-sm text-gray-500 mb-1">Software Development</div>
            <div class="font-bold text-lg mb-2">Membuat Aplikasi Android dengan Flutter</div>
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Offline</span>
                <span class="text-xs text-gray-500">+ 1 Lainnya</span>
            </div>
            <div class="text-sm mb-2">Harga <span class="font-bold">Rp70.000 </span><s>Rp100.000</s></div>
            <button class="bg-blue-600 text-white py-2 rounded mt-auto">Ikuti Pelatihan</button>
            <div class="text-xs text-gray-400 mt-2">Pelatihan dari Dicoding </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col">
            <img src="{{ asset('images/pelatihan/pelatihan1.jpg') }}" alt="Garmen Apparel" class="rounded-md h-40 object-cover mb-4">
            <div class="font-semibold text-sm text-gray-500 mb-1">Software Development</div>
            <div class="font-bold text-lg mb-2">Membuat Aplikasi Android dengan Flutter</div>
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Offline</span>
                <span class="text-xs text-gray-500">+ 1 Lainnya</span>
            </div>
            <div class="text-sm mb-2">Harga <span class="font-bold">Rp70.000 </span><s>Rp100.000</s></div>
            <button class="bg-blue-600 text-white py-2 rounded mt-auto">Ikuti Pelatihan</button>
            <div class="text-xs text-gray-400 mt-2">Pelatihan dari Dicoding </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col">
            <img src="{{ asset('images/pelatihan/pelatihan1.jpg') }}" alt="Garmen Apparel" class="rounded-md h-40 object-cover mb-4">
            <div class="font-semibold text-sm text-gray-500 mb-1">Software Development</div>
            <div class="font-bold text-lg mb-2">Membuat Aplikasi Android dengan Flutter</div>
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Offline</span>
                <span class="text-xs text-gray-500">+ 1 Lainnya</span>
            </div>
            <div class="text-sm mb-2">Harga <span class="font-bold">Rp70.000 </span><s>Rp100.000</s></div>
            <button class="bg-blue-600 text-white py-2 rounded mt-auto">Ikuti Pelatihan</button>
            <div class="text-xs text-gray-400 mt-2">Pelatihan dari Dicoding </div>
        </div>
    </div>
</div>