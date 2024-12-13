<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Network 1</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full min-h-screen py-4" style="margin: 0;">
        <div class="flex flex-col gap-6 mt-6 px-6 md:px-12 lg:px-16 max-w-screen-xl mx-auto">
            <!-- Bagian Alumni Network Deskripsi -->
            <div class="flex flex-col-reverse md:flex-row w-full">
                <div class="w-full md:w-1/2 px-6 py-2 text-black">
                    <h1 class="text-3xl font-bold text-[#003194]">Alumni Network 1</h1>
                    <h2 class="text-xl font-semibold text-gray-800 mt-4">Definisi dan Responden</h2>
                    <p class="text-base text-gray-600 mt-4 text-justify leading-relaxed">
                        Alumni Network 1 adalah studi pelacakan jejak alumni UBSI yang dilakukan 1 tahun setelah lulus, dalam
                        rangka memperoleh umpan balik guna evaluasi pelayanan serta pemberian masukan kepada Universitas Brawijaya.
                    </p>
                    <p class="text-base text-gray-600 mt-4 text-justify leading-relaxed">
                        Responden Alumni Network 1 meliputi seluruh populasi mahasiswa UBSI dari berbagai jenjang, termasuk
                        Sarjana Terapan (D4), Sarjana (S1), Magister (S2), Doktor (S3), Spesialis 1 (Sp-1), dan Profesi.
                    </p>
                </div>
                <div class="w-full md:w-1/2">
                    <img src="https://blue.kumparan.com/image/upload/fl_progressive,fl_lossy,c_fill,q_auto:best,w_640/v1634025439/01hjwcf9xtht7b1ev2mtrvryz8.jpg"
                         alt="Alumni Network Image" class="w-full h-auto rounded-lg shadow-md hover:opacity-90 transition-opacity duration-300">
                </div>
            </div>

            <!-- Bagian Pengisian Kuesioner -->
            <div class="flex flex-col md:flex-row gap-4 w-full">
                <!-- Card untuk Lulusan 2015-2020 -->
                <div class="flex flex-col p-6 text-black bg-white rounded-lg shadow-md border border-gray-300 flex-1">
                    <h2 class="text-2xl font-bold text-[#003194]">Pengisian Kuesioner</h2>
                    <h3 class="text-xl font-semibold text-gray-800 mt-2">Responden 2015-2020</h3>
                    <p class="text-base text-gray-600 mt-2 leading-relaxed">
                        Silakan klik tombol di bawah untuk mengisi kuesioner Alumni Network 1 bagi lulusan 2015-2020.
                        <br> Ingin mengisi kuesioner sekarang?
                    </p>
                    <a href="/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020"
                       class="mt-4 inline-block px-6 py-3 text-base bg-yellow-600 text-white font-semibold rounded-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                        Isi Kuesioner ⭢
                    </a>
                </div>

                <!-- Card untuk Lulusan 2021 dan Seterusnya -->
                <div class="flex flex-col p-6 text-black bg-white rounded-lg shadow-md border border-gray-300 flex-1">
                    <h2 class="text-2xl font-bold text-[#003194]">Pengisian Kuesioner</h2>
                    <h3 class="text-xl font-semibold text-gray-800 mt-2">Responden 2021-2024</h3>
                    <p class="text-base text-gray-600 mt-2 leading-relaxed">
                        Silakan klik tombol di bawah untuk mengisi kuesioner Alumni Network 1 bagi lulusan 2021-2024.
                        <br> Ingin mengisi kuesioner sekarang?
                    </p>
                    <a href="/pengisian-tracer-study/Tracer-Study-1/Q1"
                       class="mt-4 inline-block px-6 py-3 text-base bg-yellow-600 text-white font-semibold rounded-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                        Isi Kuesioner ⭢
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
