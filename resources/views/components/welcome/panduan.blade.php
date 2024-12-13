<div id="panduan" class="bg-gray-100 w-full py-6">
    <div class="flex flex-row flex-wrap md:flex-nowrap gap-4 mt-6 mb-6 px-4 md:px-8 lg:px-12 max-w-screen-xl mx-auto">
        <!-- Box 1 -->
        <div class="w-full md:w-1/2 px-6 py-2 text-black">
            <h1 class="text-2xl font-bold text-[#003194]">Alumni Network</h1>
            <h2 class="text-1xl font-semibold text-gray-600 mt-2">Manfaat dan Tujuan</h2>
            <ul class="mt-4 space-y-4 text-gray-600">
                <!-- Poin 1 dengan ikon SVG -->
                <li class="flex items-start justify-between">
                    <div class="mr-2 mt-1">
                        <img src="{{ asset('images/medal-svgrepo-com.png') }}" alt="Medal"
                            style="max-width: 37px; max-height: 37px;">
                    </div>
                    <div class="flex-1">
                        <p class="text-xl font-bold text-gray-600">Akreditasi Perguruan Tinggi</p>
                        <p class="text-base text-gray-600 text-justify">
                            Pengisian Alumni Network digunakan sebagai dasar perhitungan capaian Indikator Kinerja
                            Utama
                            yang mempengaruhi pemeringkatan perguruan tinggi.
                        </p>
                    </div>
                </li>

                <!-- Poin 2 dengan ikon Font Awesome -->
                <li class="flex items-start justify-between">
                    <div class="mr-2 mt-1">
                        <img src="{{ asset('images/connect-share-sharing-svgrepo-com.png') }}" alt="Connect Share"
                            style="max-width: 37px; max-height: 37px;">
                    </div>
                    <div class="flex-1">
                        <p class="text-xl font-bold text-gray-600">Evaluasi Relevansi Kurikulum dan Dunia Kerja</p>
                        <p class="text-base text-gray-600 text-justify">
                            Data Alumni Network digunakan sebagai bahan evaluasi kurikulum pada setiap program studi
                            agar
                            sesuai dengan kebutuhan dunia kerja sekarang.
                        </p>
                    </div>
                </li>

                <!-- Poin 3 dengan ikon Font Awesome -->
                <li class="flex items-start justify-between">
                    <div class="mr-2 mt-1">
                        <img src="{{ asset('images/gene-sequencing-svgrepo-com.png') }}" alt="Gene Sequencing"
                            style="max-width: 37px; max-height: 37px;">
                    </div>
                    <div class="flex-1">
                        <p class="text-xl font-bold text-gray-600">Membangun Jejaring Alumni</p>
                        <p class="text-base text-gray-600 text-justify">
                            Data Alumni Network dapat digunakan untuk mengetahui persebaran alumni UBSI dalam rangka
                            membangun jaringan komunitas alumni UBSI di Indonesia ataupun di dunia.
                        </p>
                    </div>
                </li>
            </ul>
            <div class="mt-6 flex justify-center gap-4">
                <!-- Button Mulai Survey -->
                <a href="/pengisian-tracer-study"
                    class="inline-block px-4 md:px-6 py-2 md:py-3 text-base md:text-lg bg-[#003194] text-white font-semibold rounded-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                    Mulai Survey
                </a>

                <!-- Button Baca Panduan -->
                <a href="/panduan"
                    class="inline-block px-4 md:px-6 py-2 md:py-3 text-base md:text-lg bg-yellow-600 text-white font-semibold rounded-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                    Baca Panduan
                </a>
            </div>
        </div>

        <!-- Box 2 -->
        <div class="w-full md:w-1/2 flex flex-col md:flex-row p-8 space-y-6 md:space-y-0">
            <!-- Card pertama di kiri -->
            <div class="flex flex-col items-start w-full p-0">
                <!-- Konten Card dengan ukuran yang sama dengan foto -->
                <div class="w-full aspect-square flex flex-col justify-center items-start bg-[#001a5c] p-4 gap-4">
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-white">Partisipasi Aktif</h3>
                        <p class="text-base text-gray-300 text-left">Alumni berpeluang untuk aktif memberikan umpan
                            balik
                            dan saran konstruktif kepada almamater.</p>
                    </div>
                </div>

                <!-- Foto Kotak dengan rasio 1:1 -->
                <div class="w-full aspect-square">
                    <img src="{{ asset('images/alumni1.jpg') }}" alt="Gambar Kartu"
                        class="object-cover w-full h-full aspect-square">
                </div>
            </div>

            <!-- Card kedua di kanan -->
            <div class="flex flex-col items-start w-full p-0 mt-6 md:mt-0">
                <!-- Foto Kotak dengan rasio 1:1 -->
                <div class="w-full aspect-square">
                    <img src="{{ asset('images/alumni2.jpg') }}" alt="Gambar Kartu Kedua"
                        class="object-cover w-full h-full aspect-square">
                </div>

                <!-- Konten Card dengan ukuran yang sama dengan foto -->
                <div class="w-full aspect-square flex flex-col justify-center items-start bg-[#660000] p-4 gap-4">
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-white">Bangun Jaringan</h3>
                        <p class="text-base text-gray-300 text-left">Data yang diberikan akan menjadi dasar dari
                            pemetaan
                            sebaran
                            alumni dan memperkuat jejaring.</p>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
