<div class="flex flex-wrap bg-cover bg-no-repeat relative" id="home">
    <video autoplay loop muted playsinline class="absolute top-0 left-0 w-full h-full object-cover">
        <source src="{{ asset('videos/hero-bg1.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="w-full sm:w-8/12 mb-10 relative z-10">
        <div class="container mx-auto min-h-screen flex items-center justify-center sm:p-10"> 
            <header class="container px-4 lg:flex items-center h-full lg:mt-0">
                <div class="w-full hero-fade-in text-left">
                    <h1 class="text-xl sm:text-2xl lg:text-4xl font-bold text-white mb-4">
                        Portal Alumni Network <br>
                        <span class="text-blue-600">Universitas Bina Sarana Informatika</span>
                    </h1>
                    <p class="text-xs sm:text-sm lg:text-base mb-10 text-white">
                        Ayo, Sukseskan Alumni Network Universitas BSI
                    </p>
                    <button class="bg-white text-black text-base font-medium px-4 py-2 rounded shadow">
                        Mulai Survey
                    </button>
                </div>
            </header>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Menunggu beberapa detik sebelum menambahkan kelas
        setTimeout(function() {
            // Menambahkan kelas ke semua elemen dengan kelas 'hero-fade-in'
            const elements = document.querySelectorAll('.hero-fade-in');
            elements.forEach(function(element) {
                element.classList.add('hero-fade-in-active');
            });
        }, 100); // Waktu tunggu sebelum efek dimulai (dalam milidetik)
    });
</script>
