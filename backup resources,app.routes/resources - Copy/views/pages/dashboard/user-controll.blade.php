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
                <div class="mt-4 mx-4">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3">Client</th>
                                        <th class="px-4 py-3">Amount</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    <!-- Loop untuk 10 row per halaman -->
                                    @foreach($users as $user)
                                    <tr class="bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                    <img class="object-cover w-full h-full rounded-full"  alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">{{ $user->name }}</p>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $user->occupation }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm">${{ number_format($user->amount, 2) }}</td>
                                        <td class="px-4 py-3 text-xs">
                                            <span class="px-2 py-1 font-semibold leading-tight text-{{ $user->status_color }}-700 bg-{{ $user->status_color }}-100 rounded-full dark:bg-{{ $user->status_color }}-700 dark:text-{{ $user->status_color }}-100">
                                                {{ $user->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">{{ $user->date }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                            <span class="flex items-center col-span-3"> Showing {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }} </span>
                            <span class="col-span-2"></span>
                            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                                {{ $users->links() }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
