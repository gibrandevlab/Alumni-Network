<div class="flex flex-wrap bg-cover bg-no-repeat relative" id="home"
 style="background-image: none; background-size: cover; background-position: center;">
    <div class="w-full sm:w-10/12 md:w-8/12 mb-10 relative z-10">
        <div class="container mx-auto min-h-screen flex items-center justify-center px-4 sm:px-6 md:px-10">
            <header class="container px-4 lg:flex items-center h-full lg:mt-0">
                <div class="w-full hero-fade-in text-left">
                    <h1 class="text-lg sm:text-xl md:text-3xl lg:text-5xl font-bold text-white mb-4">
                        Portal Alumni Network <br>
                        <span class="text-blue-500">Universitas Bina Sarana Informatika</span>
                    </h1>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl mb-6 sm:mb-8 lg:mb-10 text-white">
                        Ayo, Sukseskan Alumni Network Universitas BSI
                    </p>
                    <button class="bg-white text-black text-sm sm:text-base md:text-lg font-medium px-4 sm:px-6 py-2 sm:py-3 rounded shadow">
                        Mulai Survey
                    </button>
                </div>
            </header>
        </div>
    </div>
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/Banner-AI.png') }}" alt="Banner AI" class="w-full h-full object-cover object-center">
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