<div class="py-12 bg-white">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Our Collections</h2>
    <div class="relative flex items-center justify-center">
        <!-- Previous Button -->
        <button class="bg-gray-300 p-2 rounded-full shadow-lg absolute left-0 z-10 transform -translate-y-1/2" style="top: 50%;" onclick="slideLeft()">&#10094;</button>

        <!-- Slider Container -->
        <div class="overflow-hidden w-full px-10">
            <div id="slider" class="flex gap-6 items-center transition-transform duration-500 ease-in-out">
                <!-- Accessories -->
                <div class="text-center min-w-max">
                    <div class="rounded-full overflow-hidden w-36 h-36 mx-auto mb-4 shadow-lg">
                        <img src="{{ asset('images/hero-image.jpg') }}" alt="Accessories" class="w-full h-full object-cover">
                    </div>
                    <p class="text-lg font-semibold">Accessories</p>
                </div>

                <!-- Promotions -->
                <div class="text-center min-w-max">
                    <div class="rounded-full overflow-hidden w-36 h-36 mx-auto mb-4 shadow-lg">
                        <img src="{{ asset('images/hero-image.jpg') }}" alt="Promotions" class="w-full h-full object-cover">
                    </div>
                    <p class="text-lg font-semibold">Promotions</p>
                </div>

                <!-- Eyes -->
                <div class="text-center min-w-max">
                    <div class="rounded-full overflow-hidden w-36 h-36 mx-auto mb-4 shadow-lg">
                        <img src="{{ asset('images/hero-image.jpg') }}" alt="Eyes" class="w-full h-full object-cover">
                    </div>
                    <p class="text-lg font-semibold">Eyes</p>
                </div>

                <!-- Best-Sellers -->
                <div class="text-center min-w-max">
                    <div class="rounded-full overflow-hidden w-36 h-36 mx-auto mb-4 shadow-lg">
                        <img src="{{ asset('images/hero-image.jpg') }}" alt="Best-Sellers" class="w-full h-full object-cover">
                    </div>
                    <p class="text-lg font-semibold">Best-Sellers</p>
                </div>

                <!-- Care -->
                <div class="text-center min-w-max">
                    <div class="rounded-full overflow-hidden w-36 h-36 mx-auto mb-4 shadow-lg">
                        <img src="{{ asset('images/hero-image.jpg') }}" alt="Care" class="w-full h-full object-cover">
                    </div>
                    <p class="text-lg font-semibold">Care</p>
                </div>
            </div>
        </div>

        <!-- Next Button -->
        <button class="bg-gray-300 p-2 rounded-full shadow-lg absolute right-0 z-10 transform -translate-y-1/2" style="top: 50%;" onclick="slideRight()">&#10095;</button>
    </div>

    <div class="text-right mt-4">
        <a href="#" class="text-blue-500 hover:underline">View All</a>
    </div>
</div>

<!-- Slider JavaScript -->
<script>
    let slider = document.getElementById('slider');
    let scrollAmount = 0;
    const slideWidth = 200; // You can adjust this value as needed

    function slideLeft() {
        scrollAmount += slideWidth;
        slider.style.transform = `translateX(${scrollAmount}px)`;
    }

    function slideRight() {
        scrollAmount -= slideWidth;
        slider.style.transform = `translateX(${scrollAmount}px)`;
    }
</script>

