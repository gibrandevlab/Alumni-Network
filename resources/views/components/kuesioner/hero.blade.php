<div class="flex flex-wrap bg-cover bg-no-repeat relative justify-center items-center" id="home">
    <video autoplay loop muted playsinline class="absolute top-0 left-0 w-full h-full object-cover">
        <source src="{{ asset('videos/hero-bg1.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="w-full sm:w-8/12 mb-10 relative z-10">
        <div class="container mx-auto min-h-screen flex items-center justify-center sm:p-10">
            <header class="container px-4 lg:flex items-center justify-center h-full lg:mt-0">
                <div class="w-full mx-auto hero-fade-in text-center">
                    <h1 class="text-xl sm:text-2xl lg:text-4xl font-bold text-white mb-4">
                        Kuesioner Alumni Network <br>
                        <span class="text-blue-600">Universitas Bina Sarana Informatika</span>
                    </h1>
                    <p class="text-xs sm:text-sm lg:text-base mb-10 text-white">
                        Ayo, Sukseskan Alumni Network Universitas BSI
                    </p>
                    <a href="#pilih-tipe-responden" class="flex justify-center">
                        <button class="bg-blue-600 text-white text-base font-medium px-4 py-2 rounded shadow">
                            Pilih Kuesioner
                        </button>
                    </a>
                </div>
            </header>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const elements = document.querySelectorAll('.hero-fade-in');
            elements.forEach(function(element) {
                element.classList.add('hero-fade-in-active');
            });
        }, 100);
    });
</script>

