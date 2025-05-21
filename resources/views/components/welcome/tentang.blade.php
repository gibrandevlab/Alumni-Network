<div class="w-full mx-auto px-0 my-0 mb-12 flex flex-col" id="tentang">
    <div class="container mx-auto pt-4 md:pt-6 flex flex-col-reverse">
        <!-- Konten Tentang Nadiem -->
        <div class="flex flex-col lg:flex-row items-center bg-white rounded-lg w-full mx-auto overflow-hidden">
            <div class="lg:w-1/2 w-full order-1 lg:order-1">
                <img src="{{ url('images/nadiem-new.jpg') }}" alt="Nadiem Anwar Makarim, B.A., M.B.A."
                    class="w-full h-300px max-h-300px object-cover transition-transform duration-500 hover:scale-105">
            </div>
            <div class="lg:w-1/2 w-full order-2 lg:order-2 px-4 lg:px-8 py-6">
                <div
                    class="text-primary border border-primary rounded-full px-3 py-1 mb-4 text-xs font-semibold inline-block">
                    Tentang</div>
                <h4 class="text-sm font-bold font-sans text-gray-600 text-center mb-4">Mantan Menteri Pendidikan dan
                    Kebudayaan Republik Indonesia</h4>
                <h1 class="text-2xl font-bold text-black-600 text-center mb-4 relative"><span
                        style="display: inline-block; padding-bottom: 1px; border-bottom: 1px solid #808080; margin-bottom: -1px;">Nadiem
                        Anwar Makarim, B.A., M.B.A.</span></h1>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 mb-6 text-justify leading-relaxed">Alumni Network merupakan salah
                        satu solusi untuk memenuhi kewajiban
                        bagi
                        perguruan tinggi sesuai dengan Permendikbud No. 5 Tahun 2020 pasal 36 ayat 7, yang menyebutkan:
                        “Perguruan tinggi yang telah mendapatkan izin penyelenggaraan program studi sebagaimana dimaksud
                        pada ayat (6) setiap tahun wajib melakukan pendataan atas penyerapan lulusan di dunia kerja
                        setelah
                        meluluskan Mahasiswa dan melaporkan hasil pendataan kepada Menteri melalui PDDIKTI”</p>
                </div>
                <div class="flex justify-center gap-6">
                    <a href="#" class="text-blue-500 transition duration-200 hover:text-blue-700"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-blue-500 transition duration-200 hover:text-blue-700"><i
                            class="fab fa-twitter"></i></a>
                    <a href="#" class="text-pink-500 transition duration-200 hover:text-pink-700"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#" class="text-blue-600 transition duration-200 hover:text-blue-800"><i
                            class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row items-center bg-white rounded-lg w-full mx-auto overflow-hidden ">
            <div class="lg:w-1/2 w-full order-2 lg:order-1 px-4 lg:px-8 py-6">
                <div
                    class="text-primary border border-primary rounded-full px-3 py-1 mb-4 text-xs font-semibold inline-block">
                    Tentang</div>
                <h2 class="text-2xl font-bold text-black text-center mb-4 relative">Alumni Network</h2>
                <h3 class="text-sm font-bold font-sans text-gray-600 text-center mb-4">Apa itu Alumni Network dan siapa
                    respondennya?</h3>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 mb-6 text-justify leading-relaxed">Alumni Network BSI adalah studi
                        pelacakan jejak alumni BSI yang dilakukan beberapa bulan/tahun setelah lulus dalam rangka
                        memperoleh
                        umpan balik dari alumni guna mengevaluasi proses pelayanan dan pemberian masukan kepada
                        Universitas
                        Bina Sarana Informatika. Alumni Network BSI menggunakan target responden seluruh populasi
                        lulusan
                        tahun tertentu dari Universitas Bina Sarana Informatika. Simak video edukasi berikut untuk lebih
                        memahami Alumni Network BSI.</p>
                </div>
                <div class="flex justify-center gap-6">
                    <a href="#" class="text-blue-500 transition duration-200 hover:text-blue-700"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-blue-500 transition duration-200 hover:text-blue-700"><i
                            class="fab fa-twitter"></i></a>
                    <a href="#" class="text-pink-500 transition duration-200 hover:text-pink-700"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#" class="text-blue-600 transition duration-200 hover:text-blue-800"><i
                            class="fab fa-linkedin"></i></a>
                </div>
            </div>

            <!-- Video YouTube -->
            <div class="lg:w-1/2 w-full order-1 lg:order-2">
                <div class="video-container">
                    <iframe src="https://www.youtube.com/embed/XTLH0Vzaa6Y" title="Alumni Network BSI" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>


</div>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script>
    function toggleAccordion(event) {
        const button = event.currentTarget;
        const content = button.nextElementSibling;

        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            button.querySelector('span').textContent = '−'; // Change to minus sign
        } else {
            content.classList.add('hidden');
            button.querySelector('span').textContent = '+'; // Change to plus sign
        }
    }
</script>

<style>
    .video-container {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 56.25%;
        /* Default 16:9 aspect ratio */
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
