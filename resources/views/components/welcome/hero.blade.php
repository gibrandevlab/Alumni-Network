<div class="flex flex-wrap bg-cover bg-no-repeat relative min-h-screen" id="home">
    <img src="{{ asset('images/bg-grad.jpg') }}" alt="Background Cover" class="absolute top-0 left-0 w-full h-full object-cover z-0" />
    <!-- Overlay gradasi gelap -->
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-black/70 via-black/40 to-black/80 z-0"></div>

    <div class="w-full sm:w-8/12 mb-10 relative z-10">
        <div class="container mx-auto min-h-screen flex items-center justify-center sm:p-10">
            <header class="container px-4 lg:flex items-center h-full lg:mt-0">
                <div class="w-full hero-fade-in text-left">
                    <h1 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold text-white mb-6 drop-shadow-lg transition-all duration-700">
                        Portal Alumni Network <br>
                        <span class="text-blue-500">Universitas Bina Sarana Informatika</span>
                    </h1>
                    <p class="text-lg sm:text-xl lg:text-2xl mb-10 text-white font-light drop-shadow-md transition-all duration-700">
                        “Kontribusi Anda sangat berarti untuk kemajuan kampus dan dunia pendidikan.”
                    </p>
                    <a href="/pengisian-tracer-study"
                        <button class="bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold px-8 py-4 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300">
                        Mulai Survey
                        </button>
                    </a>
                </div>
            </header>
        </div>
    </div>

</div>

<style>
    .hero-fade-in {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1), transform 1s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-fade-in-active {
        opacity: 1;
        transform: translateY(0);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const elements = document.querySelectorAll('.hero-fade-in');
            elements.forEach(function(element) {
                element.classList.add('hero-fade-in-active');
            });
        }, 200);
    });
</script>