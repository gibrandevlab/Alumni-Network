<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alumni Network BSI</title>
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    @vite('resources/css/app.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
    <div x-data="setup()" :class="{ 'dark': isDark }">
        <div
            class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">

            <!-- navbar bagian atas -->
            @include('layouts.Dashboard.navbaratas')
            <!-- end- navbar bagian atas -->

            <!-- Sidebar bagian kiri -->
            @include('layouts.Dashboard.sidebarkiri')
            <!-- Sidebar bagian kiri -->

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64">

                <!--Bagian Jumlah Statistik secara numerik (admin) -->
                @if ($peranPengguna == 'admin')
                    @include('components.dashboard.statistikangka', [
                        'jumlahPenggunaDisetujui' => $jumlahPenggunaDisetujui,
                    ])
                @endif

                <!--Bagian Jumlah Statistik secara numerik -->

                <div class="grid grid-cols-1 lg:grid-cols-2 p-4 gap-4">

                    <!-- Partisipasi Alumni Pertahun - Kolom 1 -->
                    @include('components.dashboard.partisipasitahunan')

                    <!-- Partisipasi Alumni Pertahun - Kolom 2 -->
                    @include('components.dashboard.test')

                </div>


                <!-- Task Summaries -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 p-4 gap-4 text-black dark:text-white">
                    <div class="md:col-span-2 xl:col-span-3">
                        <h3 class="text-lg font-semibold">Task summaries of recent sprints</h3>
                    </div>
                    <div class="md:col-span-2 xl:col-span-1">
                        <div class="rounded bg-gray-200 dark:bg-gray-800 p-3">
                            <div class="flex justify-between py-1 text-black dark:text-white">
                                <h3 class="text-sm font-semibold">Tasks in TO DO</h3>
                                <svg class="h-4 fill-current text-gray-600 dark:text-gray-500 cursor-pointer"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M5 10a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4zm7 0a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4zm7 0a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4z" />
                                </svg>
                            </div>
                            <div class="text-sm text-black dark:text-gray-50 mt-2">
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Delete all references from the wiki</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Remove analytics code</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Do a mobile first layout
                                    <div
                                        class="text-gray-500 dark:text-gray-200 mt-2 ml-2 flex justify-between items-start">
                                        <span class="text-xs flex items-center">
                                            <svg class="h-4 fill-current mr-1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 50 50">
                                                <path
                                                    d="M11 4c-3.855 0-7 3.145-7 7v28c0 3.855 3.145 7 7 7h28c3.855 0 7-3.145 7-7V11c0-3.855-3.145-7-7-7zm0 2h28c2.773 0 5 2.227 5 5v28c0 2.773-2.227 5-5 5H11c-2.773 0-5-2.227-5-5V11c0-2.773 2.227-5 5-5zm25.234 9.832l-13.32 15.723-8.133-7.586-1.363 1.465 9.664 9.015 14.684-17.324z" />
                                            </svg>
                                            3/5
                                        </span>
                                        <img src="https://i.imgur.com/OZaT7jl.png" class="rounded-full" />
                                    </div>
                                </div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Check the meta tags</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Think more tasks for this example
                                    <div
                                        class="text-gray-500 dark:text-gray-200 mt-2 ml-2 flex justify-between items-start">
                                        <span class="text-xs flex items-center">
                                            <svg class="h-4 fill-current mr-1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 50 50">
                                                <path
                                                    d="M11 4c-3.855 0-7 3.145-7 7v28c0 3.855 3.145 7 7 7h28c3.855 0 7-3.145 7-7V11c0-3.855-3.145-7-7-7zm0 2h28c2.773 0 5 2.227 5 5v28c0 2.773-2.227 5-5 5H11c-2.773 0-5-2.227-5-5V11c0-2.773 2.227-5 5-5zm25.234 9.832l-13.32 15.723-8.133-7.586-1.363 1.465 9.664 9.015 14.684-17.324z" />
                                            </svg>
                                            0/3
                                        </span>
                                    </div>
                                </div>
                                <p class="mt-3 text-gray-600 dark:text-gray-400">Add a card...</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="rounded bg-gray-200 dark:bg-gray-800 p-3">
                            <div class="flex justify-between py-1 text-black dark:text-white">
                                <h3 class="text-sm font-semibold">Tasks in DEVELOPMENT</h3>
                                <svg class="h-4 fill-current text-gray-600 dark:text-gray-500 cursor-pointer"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M5 10a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4zm7 0a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4zm7 0a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4z" />
                                </svg>
                            </div>
                            <div class="text-sm text-black dark:text-gray-50 mt-2">
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Delete all references from the wiki</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Remove analytics code</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Do a mobile first layout
                                    <div class="flex justify-between items-start mt-2 ml-2 text-white text-xs">
                                        <span class="bg-pink-600 rounded p-1 text-xs flex items-center">
                                            <svg class="h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2c-.8 0-1.5.7-1.5 1.5v.688C7.344 4.87 5 7.62 5 11v4.5l-2 2.313V19h18v-1.188L19 15.5V11c0-3.379-2.344-6.129-5.5-6.813V3.5c0-.8-.7-1.5-1.5-1.5zm-2 18c0 1.102.898 2 2 2 1.102 0 2-.898 2-2z" />
                                            </svg>
                                            2
                                        </span>
                                    </div>
                                </div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Check the meta tags</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Think more tasks for this example
                                    <div class="text-gray-500 mt-2 ml-2 flex justify-between items-start">
                                        <span class="text-xs flex items-center">
                                            <svg class="h-4 fill-current mr-1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 50 50">
                                                <path
                                                    d="M11 4c-3.855 0-7 3.145-7 7v28c0 3.855 3.145 7 7 7h28c3.855 0 7-3.145 7-7V11c0-3.855-3.145-7-7-7zm0 2h28c2.773 0 5 2.227 5 5v28c0 2.773-2.227 5-5 5H11c-2.773 0-5-2.227-5-5V11c0-2.773 2.227-5 5-5zm25.234 9.832l-13.32 15.723-8.133-7.586-1.363 1.465 9.664 9.015 14.684-17.324z" />
                                            </svg>
                                            0/3
                                        </span>
                                    </div>
                                </div>
                                <p class="mt-3 text-gray-600 dark:text-gray-400">Add a card...</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="rounded bg-gray-200 dark:bg-gray-800 p-3">
                            <div class="flex justify-between py-1 text-black dark:text-white">
                                <h3 class="text-sm font-semibold">Tasks in QA</h3>
                                <svg class="h-4 fill-current text-gray-600 dark:text-gray-500 cursor-pointer"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M5 10a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4zm7 0a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4zm7 0a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4z" />
                                </svg>
                            </div>
                            <div class="text-sm text-black dark:text-gray-50 mt-2">
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Delete all references from the wiki</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Remove analytics code</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Do a mobile first layout</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Check the meta tags</div>
                                <div
                                    class="bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded mt-1 border-b border-gray-100 dark:border-gray-900 cursor-pointer">
                                    Think more tasks for this example
                                    <div
                                        class="text-gray-500 dark:text-gray-200 mt-2 ml-2 flex justify-between items-start">
                                        <span class="text-xs flex items-center">
                                            <svg class="h-4 fill-current mr-1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 50 50">
                                                <path
                                                    d="M11 4c-3.855 0-7 3.145-7 7v28c0 3.855 3.145 7 7 7h28c3.855 0 7-3.145 7-7V11c0-3.855-3.145-7-7-7zm0 2h28c2.773 0 5 2.227 5 5v28c0 2.773-2.227 5-5 5H11c-2.773 0-5-2.227-5-5V11c0-2.773 2.227-5 5-5zm25.234 9.832l-13.32 15.723-8.133-7.586-1.363 1.465 9.664 9.015 14.684-17.324z" />
                                            </svg>
                                            0/3
                                        </span>
                                    </div>
                                </div>
                                <p class="mt-3 text-gray-600 dark:text-gray-400">Add a card...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Task Summaries -->

                <!-- Contact Form -->
                <div class="mt-8 mx-4">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6 mr-2 bg-gray-100 dark:bg-gray-800 sm:rounded-lg">
                            <h1
                                class="text-4xl sm:text-5xl text-gray-800 dark:text-white font-extrabold tracking-tight">
                                Get in touch</h1>
                            <p
                                class="text-normal text-lg sm:text-2xl font-medium text-gray-600 dark:text-gray-400 mt-2">
                                Fill in the form to submit any query</p>

                            <div class="flex items-center mt-8 text-gray-600 dark:text-gray-400">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"
                                    class="w-8 h-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div class="ml-4 text-md tracking-wide font-semibold w-40">Dhaka, Street, State, Postal
                                    Code</div>
                            </div>

                            <div class="flex items-center mt-4 text-gray-600 dark:text-gray-400">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"
                                    class="w-8 h-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div class="ml-4 text-md tracking-wide font-semibold w-40">+880 1234567890</div>
                            </div>

                            <div class="flex items-center mt-4 text-gray-600 dark:text-gray-400">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"
                                    class="w-8 h-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div class="ml-4 text-md tracking-wide font-semibold w-40">info@demo.com</div>
                            </div>
                        </div>
                        <form class="p-6 flex flex-col justify-center">
                            <div class="flex flex-col">
                                <label for="name" class="hidden">Full Name</label>
                                <input type="name" name="name" id="name" placeholder="Full Name"
                                    class="w-100 mt-2 py-3 px-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-400 dark:border-gray-700 text-gray-800 dark:text-gray-50 font-semibold focus:border-blue-500 focus:outline-none" />
                            </div>

                            <div class="flex flex-col mt-2">
                                <label for="email" class="hidden">Email</label>
                                <input type="email" name="email" id="email" placeholder="Email"
                                    class="w-100 mt-2 py-3 px-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-400 dark:border-gray-700 text-gray-800 dark:text-gray-50 font-semibold focus:border-blue-500 focus:outline-none" />
                            </div>

                            <div class="flex flex-col mt-2">
                                <label for="tel" class="hidden">Number</label>
                                <input type="tel" name="tel" id="tel" placeholder="Telephone Number"
                                    class="w-100 mt-2 py-3 px-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-400 dark:border-gray-700 text-gray-800 dark:text-gray-50 font-semibold focus:border-blue-500 focus:outline-none" />
                            </div>

                            <button type="submit"
                                class="md:w-32 bg-blue-600 dark:bg-gray-100 text-white dark:text-gray-800 font-bold py-3 px-6 rounded-lg mt-4 hover:bg-blue-500 dark:hover:bg-gray-200 transition ease-in-out duration-300">Submit</button>
                        </form>
                    </div>
                </div>
                <!-- ./Contact Form -->

                <!-- External resources -->
                <div class="mt-8 mx-4">
                    <div
                        class="p-4 bg-blue-50 dark:bg-gray-800 dark:text-gray-50 border border-blue-500 dark:border-gray-500 rounded-lg shadow-md">
                        <h4 class="text-lg font-semibold">Have taken ideas & reused components from the following
                            resources:</h4>
                        <ul>
                            <li class="mt-3">
                                <a class="flex items-center text-blue-700 dark:text-gray-100"
                                    href="https://tailwindcomponents.com/component/sidebar-navigation-1"
                                    target="_blank">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        class="transform transition-transform duration-500 ease-in-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="inline-flex pl-2">Sidebar Navigation</span>
                                </a>
                            </li>
                            <li class="mt-2">
                                <a class="flex items-center text-blue-700 dark:text-gray-100"
                                    href="https://tailwindcomponents.com/component/contact-form-1" target="_blank">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        class="transform transition-transform duration-500 ease-in-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="inline-flex pl-2">Contact Form</span>
                                </a>
                            </li>
                            <li class="mt-2">
                                <a class="flex items-center text-blue-700 dark:text-gray-100"
                                    href="https://tailwindcomponents.com/component/trello-panel-clone"
                                    target="_blank">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        class="transform transition-transform duration-500 ease-in-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="inline-flex pl-2">Section: Task Summaries</span>
                                </a>
                            </li>
                            <li class="mt-2">
                                <a class="flex items-center text-blue-700 dark:text-gray-100"
                                    href="https://windmill-dashboard.vercel.app/" target="_blank">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        class="transform transition-transform duration-500 ease-in-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="inline-flex pl-2">Section: Client Table</span>
                                </a>
                            </li>
                            <li class="mt-2">
                                <a class="flex items-center text-blue-700 dark:text-gray-100"
                                    href="https://demos.creative-tim.com/notus-js/pages/admin/dashboard.html"
                                    target="_blank">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        class="transform transition-transform duration-500 ease-in-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="inline-flex pl-2">Section: Social Traffic</span>
                                </a>
                            </li>
                            <li class="mt-2">
                                <a class="flex items-center text-blue-700 dark:text-gray-100"
                                    href="https://mosaic.cruip.com" target="_blank">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        class="transform transition-transform duration-500 ease-in-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="inline-flex pl-2">Section: Recent Activities</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- ./External resources -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <script>
        const setup = () => {
            const getTheme = () => {
                if (window.localStorage.getItem('dark')) {
                    return JSON.parse(window.localStorage.getItem('dark'))
                }
                return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            }

            const setTheme = (value) => {
                window.localStorage.setItem('dark', value)
            }

            return {
                loading: true,
                isDark: getTheme(),
                toggleTheme() {
                    this.isDark = !this.isDark
                    setTheme(this.isDark)
                },
            }
        }
    </script>
</body>

</html>
