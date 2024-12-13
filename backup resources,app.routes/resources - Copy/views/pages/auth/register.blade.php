<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobana - Register</title>
    <meta name="description" content="Register for your Gobana account">
    <meta name="keywords" content="register, gobana, account">
    @vite('resources/css/app.css')
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body id="background" class="relative min-h-screen bg-cover bg-center">
    <div class="absolute inset-0 bg-blue-700 opacity-80 z-10"></div>

    <div class="absolute top-4 left-4 z-[1000] flex items-center">
        <a href="/" class="text-white font-semibold hover:underline flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#FFFFFF" version="1.1" width="24px" height="24px"
                viewBox="0 0 495.398 495.398" xml:space="preserve" class="mr-1">
                <g>
                    <g>
                        <g>
                            <path
                                d="M487.083,225.514l-75.08-75.08V63.704c0-15.682-12.708-28.391-28.413-28.391c-15.669,0-28.377,12.709-28.377,28.391v29.941L299.31,37.74c-27.639-27.624-75.694-27.575-103.27,0.05L8.312,225.514c-11.082,11.104-11.082,29.071,0,40.158c11.087,11.101,29.089,11.101,40.172,0l187.71-187.729c6.115-6.083,16.893-6.083,22.976-0.018l187.742,187.747c5.567,5.551,12.825,8.312,20.081,8.312c7.271,0,14.541-2.764,20.091-8.312C498.17,254.586,498.17,236.619,487.083,225.514z" />
                            <path
                                d="M257.561,131.836c-5.454-5.451-14.285-5.451-19.723,0L72.712,296.913c-2.607,2.606-4.085,6.164-4.085,9.877v120.401c0,28.253,22.908,51.16,51.16,51.16h81.754v-126.61h92.299v126.61h81.755c28.251,0,51.159-22.907,51.159-51.159V306.79c0-3.713-1.465-7.271-4.085-9.877L257.561,131.836z" />
                        </g>
                    </g>
                </g>
            </svg>
        </a>
    </div>

    <div class="relative z-20 flex items-center justify-center min-h-screen">
        <div class="p-8 rounded-lg max-w-md w-full fade-in" id="register-form">
            <h2 class="text-center text-2xl font-bold text-white mb-6">Register</h2>

            @if(session('success'))
                <div class="text-green-500 text-center mb-4">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="text-red-500 text-center mb-4">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Email"
                    class="w-full px-4 py-2 mb-4 rounded-full text-blue-600 placeholder-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    required>
                <input type="password" name="password" placeholder="Password"
                    class="w-full px-4 py-2 mb-6 rounded-full text-blue-600 placeholder-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    required>
                <div class="flex flex-wrap justify-center">
                    <a href="{{ route('login') }}"
                        class="text-white font-semibold py-2 px-4 rounded-lg hover:bg-opacity-75 transition duration-300 flex-1 min-w-[120px] mx-2">Login</a>
                    <button type="submit"
                        class="bg-white text-blue-600 font-semibold py-2 px-4 rounded-full hover:bg-opacity-75 transition duration-300 flex-1 min-w-[120px] mx-2">Register</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const backgroundElement = document.getElementById('background');
            backgroundElement.style.backgroundImage = "url('{{ asset('images/loginbg.jpg') }}')";

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            });

            const registerForm = document.getElementById('register-form');
            observer.observe(registerForm);
        });
    </script>
</body>

</html>
