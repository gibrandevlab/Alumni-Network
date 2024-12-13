<div id="berita">
    <!-- Container utama tanpa background -->
    <div class="w-full">
        <div class="container mx-auto flex flex-col lg:flex-col items-center justify-center lg:justify-between">
            <!-- Judul berita -->
            <div class="text-center mb-8 ">
                <div class="flex items-center">
                    <hr class="flex-grow border-gray-300">
                    <h1 class="px-4 text-3xl font-bold text-[#003194] leading-tight truncate">Berita Terbaru</h1>
                    <hr class="flex-grow border-gray-300">
                </div>
                <h2 class="text-xl text-gray-600 mt-2 leading-tight truncate">Terkait Pelaksanaan Alumni Network</h2>
            </div>


            <!-- Wrapper konten dengan lebar penuh -->
            <div class="w-full flex flex-col lg:flex-row gap-4 px-4 lg:px-12">
                <!-- Box 1: Gambar utama -->
                <div class="w-full lg:w-1/2 relative overflow-hidden group">
                    <img src="{{ asset('images/bimtek.jpg') }}" alt="Gambar Berita"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute top-0 left-0 bg-blue-800 text-white px-4 py-2 rounded-br-lg shadow-md">
                        <span class="font-semibold text-sm">Berita</span>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 bg-black bg-opacity-50 text-white">
                        <h3 class="text-md font-bold leading-tight line-clamp-2">Sosialisasi dan Bimtek Alumni Network
                            Sebagai
                            Upaya Meningkatkan Kualitas Lulusan SMK</h3>
                        <p class="text-xs leading-tight">28 Agustus 2024</p>
                    </div>
                </div>

                <!-- Box 2: Card kecil -->
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <!-- Card 1: Full row -->
                    <div class="flex flex-col relative rounded-lg overflow-hidden bg-gray-50 group">
                        <img src="https://news.bsi.ac.id/wp-content/uploads/2024/11/IMG20241030100138-750x430.jpg"
                            alt="Gambar Card 1"
                            class="w-full h-48 object-cover rounded-lg transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute top-0 left-0 bg-blue-800 text-white px-4 py-2 rounded-br-lg shadow-md">
                            <span class="font-semibold text-sm">Berita</span>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 bg-black bg-opacity-50 text-white">
                            <h3 class="text-md font-bold leading-tight line-clamp-2">Guru dan Siswa Bekasi Antusias
                                Ikuti Workshop Pemuda Digital di Universitas BSI Kampus Kaliabang</h3>
                            <p class="text-xs leading-tight">11 November 2024</p>
                        </div>
                    </div>

                    <!-- Card 2 dan Card 3: Berbagi row -->
                    <div class="flex gap-4">
                        <!-- Card 2 -->
                        <div class="flex-1 flex flex-col relative rounded-lg overflow-hidden bg-gray-50 group">
                            <img src="https://news.bsi.ac.id/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-06-at-10.39.54-750x430.jpeg"
                                alt="Gambar Card 2"
                                class="w-full h-48 object-cover rounded-lg transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute top-0 left-0 bg-blue-800 text-white px-4 py-2 rounded-br-lg shadow-md">
                                <span class="font-semibold text-sm">Berita</span>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-black bg-opacity-50 text-white">
                                <h3 class="text-md font-bold leading-tight line-clamp-2">Siapa Bilang Mahasiswa Baru Gak
                                    Bisa Fashionable? Mahasiswa BSI Pontianak Buktikan di Ajang Fashion Show ‘Korea
                                    Style’!</h3>
                                <p class="text-xs leading-tight">11 November 2024</p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="flex-1 flex flex-col relative rounded-lg overflow-hidden bg-gray-50 group">
                            <img src="https://news.bsi.ac.id/wp-content/uploads/2024/11/Gambar-kupu-kupu-750x430.jpg"
                                alt="Gambar Card 3"
                                class="w-full h-48 object-cover rounded-lg transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute top-0 left-0 bg-blue-800 text-white px-4 py-2 rounded-br-lg shadow-md">
                                <span class="font-semibold text-sm">Berita</span>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-black bg-opacity-50 text-white">
                                <h3 class="text-md font-bold leading-tight line-clamp-2">Dosen Universitas BSI Kampus
                                    Tegal Teliti Kupu-Kupu dengan Color Histogram dan Random Forest</h3>
                                <p class="text-xs leading-tight">6 November 2024</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
