<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnet - Login</title>
    <meta name="description" content="Login to your Gobana account">
    <meta name="keywords" content="login, gobana, account">
    @vite('resources/css/app.css')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .floating-shape {
            position: absolute;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.3), rgba(37, 99, 235, 0.1));
            border-radius: 50%;
            filter: blur(10px);
            z-index: 0;
            animation: float 20s infinite;
        }

        .shape-1 {
            width: 150px;
            height: 150px;
            top: 10%;
            left: 15%;
            animation-delay: -2s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 15%;
            animation-delay: -5s;
        }

        .shape-3 {
            width: 120px;
            height: 120px;
            top: 30%;
            right: 25%;
            animation-delay: -7s;
        }

        .shape-4 {
            width: 180px;
            height: 180px;
            bottom: 20%;
            left: 25%;
            animation-delay: -11s;
        }

        .curved-shape {
            position: absolute;
            width: 100px;
            height: 50px;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.1));
            border-radius: 100px 100px 0 0;
            filter: blur(8px);
            animation: floatCurved 15s infinite;
        }

        .curved-1 {
            top: 20%;
            right: 30%;
            transform: rotate(45deg);
            animation-delay: -3s;
        }

        .curved-2 {
            bottom: 30%;
            left: 20%;
            transform: rotate(-30deg);
            animation-delay: -8s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(20px, -20px) rotate(90deg);
            }
            50% {
                transform: translate(-10px, 20px) rotate(180deg);
            }
            75% {
                transform: translate(-20px, -10px) rotate(270deg);
            }
        }

        @keyframes floatCurved {
            0%, 100% {
                transform: translate(0, 0) rotate(45deg);
            }
            50% {
                transform: translate(-20px, 20px) rotate(60deg);
            }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .social-button {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-button:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-700 to-blue-800 relative overflow-hidden">
    <!-- Floating Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    <div class="floating-shape shape-4"></div>
    <div class="curved-shape curved-1"></div>
    <div class="curved-shape curved-2"></div>

    <!-- Notification -->
    @if (session('notif_login'))
    <div class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-red-600 text-white p-4 rounded-b-lg shadow-md z-50 w-auto max-w-md">
        <div class="flex justify-between items-center">
            <span>{{ session('notif_login') }}</span>
            <button class="ml-4 text-white focus:outline-none" onclick="this.parentElement.parentElement.style.display='none'">
                &times;
            </button>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-green-600 text-white p-4 rounded-b-lg shadow-md z-50 w-auto max-w-md">
        <div class="flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button class="ml-4 text-white focus:outline-none" onclick="this.parentElement.parentElement.style.display='none'">
                &times;
            </button>
        </div>
    </div>
    @endif

    <div class="relative z-20 flex items-center justify-center min-h-screen p-4">
        <div class="glass-effect p-8 w-full max-w-md fade-in" id="login-form">
            <!-- Logo -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logoAlumnetFix.png') }}" alt="Alumni Network Logo" class="mx-auto h-12">
            </div>

            <h2 class="text-center text-2xl font-bold text-white mb-6">Login</h2>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label class="text-white text-sm">Email</label>
                    <input type="email" name="email" placeholder="username@gmail.com"
                        class="w-full px-4 py-2 rounded-lg bg-white/90 text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div class="space-y-2">
                    <label class="text-white text-sm">Password</label>
                    <input type="password" name="password" placeholder="Password"
                        class="w-full px-4 py-2 rounded-lg bg-white/90 text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div class="text-right">
                    <a href="#" class="text-sm text-white/80 hover:text-white">Forgot Password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-900 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-800 transition duration-300">
                    Sign in
                </button>

                <div class="text-center text-white/80 text-sm">
                    or continue with
                </div>

                <div class="flex justify-center gap-4">
                    <a href="{{ route('login.google') }}" class="social-button">
                        <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5">
                    </a>
                    <a href="#" class="social-button">
                        <img src="https://github.com/favicon.ico" alt="GitHub" class="w-5 h-5">
                    </a>
                    <a href="#" class="social-button">
                        <img src="https://facebook.com/favicon.ico" alt="Facebook" class="w-5 h-5">
                    </a>
                </div>

                <div class="text-center text-white/80 text-sm">
                    Don't have an account yet?
                    <a href="/register" class="text-white hover:underline">Register for free</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            });

            const loginForm = document.getElementById('login-form');
            observer.observe(loginForm);
        });
    </script>
</body>
</html>
