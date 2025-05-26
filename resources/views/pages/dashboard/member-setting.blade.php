@extends('layouts.Dashboard.dashboard')

@section('content')
    <div class="min-h-screen flex flex-row bg-blue-50 dark:bg-gray-900 text-black dark:text-white">

        @include('layouts.Dashboard.sidebarkiri', [], ['class' => 'w-64 flex-shrink-0'])

        <div class="flex-1 flex flex-col min-w-0 p-4 md:p-6 lg:p-8 overflow-x-auto ml-14 md:ml-64" id="mainContentainer">
            @php
                $totalAlumni = $alumni ? $alumni->total() : 0;
                $alumniItems = $alumni ? $alumni->getCollection() : collect();
                $pendingCount = $alumniItems->where('status', 'pending')->count();
                $approvedCount = $alumniItems->where('status', 'approved')->count();
                $rejectedCount = $alumniItems->where('status', 'rejected')->count();
                $responseRate = $totalAlumni > 0 ? round(($approvedCount / $totalAlumni) * 100, 2) : 0;
            @endphp

            <header class="mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-blue-900 dark:text-white">Alumni Management Dashboard</h1>
                <p class="text-blue-600 dark:text-gray-400 mt-2">Manage and monitor alumni data and statistics</p>
            </header>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
                <!-- Total Alumni Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-blue-200 dark:border-gray-700 p-4 md:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $totalAlumni }}</p>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Total Alumni</p>
                        </div>
                    </div>
                    <div class="mt-3 md:mt-4 h-1 bg-blue-200 dark:bg-blue-800 rounded-full">
                        <div class="h-1 bg-blue-500 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <!-- Awaiting Verification Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-blue-200 dark:border-gray-700 p-4 md:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingCount }}</p>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Awaiting Verification</p>
                        </div>
                    </div>
                    <div class="mt-3 md:mt-4 h-1 bg-yellow-200 dark:bg-yellow-800 rounded-full">
                        <div class="h-1 bg-yellow-500 rounded-full" style="width: {{ $totalAlumni > 0 ? ($pendingCount / $totalAlumni) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <!-- Response Rate Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-blue-200 dark:border-gray-700 p-4 md:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $responseRate }}%</p>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Response Rate</p>
                        </div>
                    </div>
                    <div class="mt-3 md:mt-4 h-1 bg-blue-200 dark:bg-blue-800 rounded-full">
                        <div class="h-1 bg-blue-500 rounded-full" style="width: {{ $responseRate }}%"></div>
                    </div>
                </div>

                <!-- Approved Alumni Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-blue-200 dark:border-gray-700 p-4 md:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $approvedCount }}</p>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Approved Alumni</p>
                        </div>
                    </div>
                    <div class="mt-3 md:mt-4 h-1 bg-green-200 dark:bg-green-800 rounded-full">
                        <div class="h-1 bg-green-500 rounded-full" style="width: {{ $totalAlumni > 0 ? ($approvedCount / $totalAlumni) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 flex-1">
                <!-- Alumni Management Table -->
                <div class="lg:col-span-2 flex flex-col min-w-0">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-blue-200 dark:border-gray-700">
                        <!-- Header with improved responsive design -->
                        <div class="p-4 md:p-6 border-b border-blue-200 dark:border-gray-700">
                            <div class="flex flex-col space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <h3 class="text-lg font-semibold text-blue-900 dark:text-white">Alumni Management</h3>
                                    <button onclick="openCreateModal()"
                                            class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah Alumni
                                    </button>
                                </div>

                                <!-- Search and Filter Form -->
                                <form method="GET" action="{{ url()->current() }}" class="flex flex-col sm:flex-row gap-3">
                                    <div class="flex-1">
                                        <input type="text"
                                               name="search"
                                               value="{{ request('search') }}"
                                               placeholder="Cari nama atau email..."
                                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <div class="sm:w-48">
                                        <select name="jurusan"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Semua Jurusan</option>
                                            @foreach($jurusanList ?? [] as $jurusan)
                                                <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex gap-2">
                                        <button type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                            Filter
                                        </button>

                                        @if(request('search') || request('jurusan'))
                                            <a href="{{ url()->current() }}"
                                               class="px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                                                Reset
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-blue-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-blue-700 dark:text-gray-300 uppercase tracking-wider">No</th>
                                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-blue-700 dark:text-gray-300 uppercase tracking-wider">NIM</th>
                                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-blue-700 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-blue-700 dark:text-gray-300 uppercase tracking-wider">Jurusan</th>
                                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-blue-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-blue-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @if ($alumni && count($alumni) > 0)
                                        @foreach ($alumni as $index => $alumniItem)
                                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                                <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                    {{ ($alumni->currentPage() - 1) * $alumni->perPage() + $index + 1 }}
                                                </td>
                                                <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                    {{ $alumniItem->profilAlumni->nim ?? '-' }}
                                                </td>
                                                <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-8 w-8">
                                                            <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-600 flex items-center justify-center">
                                                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
                                                                    {{ substr($alumniItem->nama, 0, 1) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="ml-3">
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $alumniItem->nama }}</div>
                                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $alumniItem->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                    {{ $alumniItem->profilAlumni->jurusan ?? '-' }}
                                                </td>
                                                <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $statusConfig = [
                                                            'pending' => ['bg-yellow-100 text-yellow-800', 'bg-yellow-500'],
                                                            'approved' => ['bg-green-100 text-green-800', 'bg-green-500'],
                                                            'rejected' => ['bg-red-100 text-red-800', 'bg-red-500'],
                                                        ];
                                                        $config = $statusConfig[$alumniItem->status] ?? ['bg-gray-100 text-gray-800', 'bg-gray-500'];
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config[0] }}">
                                                        <div class="w-1.5 h-1.5 {{ $config[1] }} rounded-full mr-1.5"></div>
                                                        {{ ucfirst($alumniItem->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-1">
                                                        <button type="button"
                                                                onclick="openViewModal({{ $alumniItem->id }})"
                                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 p-2 rounded-md hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors duration-150"
                                                                title="Lihat Detail">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                        </button>
                                                        <button type="button"
                                                                onclick="openEditModal({{ $alumniItem->id }})"
                                                                class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 p-2 rounded-md hover:bg-yellow-50 dark:hover:bg-yellow-900 transition-colors duration-150"
                                                                title="Edit">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                        </button>
                                                        <button type="button"
                                                                onclick="openDeleteModal({{ $alumniItem->id }}, '{{ addslashes($alumniItem->nama) }}')"
                                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-2 rounded-md hover:bg-red-50 dark:hover:bg-red-900 transition-colors duration-150"
                                                                title="Hapus">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                    </svg>
                                                    <p class="text-lg font-medium">Tidak ada data alumni</p>
                                                    <p class="text-sm">Belum ada alumni yang terdaftar dalam sistem</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($alumni && $alumni->hasPages())
                            <div class="px-4 md:px-6 py-4 border-t border-blue-200 dark:border-gray-700">
                                {{ $alumni->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status Overview -->
                <div class="lg:col-span-1 flex flex-col min-w-0">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-blue-200 dark:border-gray-700 p-4 md:p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-blue-900 dark:text-white">Status Overview</h3>
                        </div>

                        <!-- Status Distribution -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Approved</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $approvedCount }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Pending</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $pendingCount }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Rejected</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $rejectedCount }}</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-8 pt-6 border-t border-blue-200 dark:border-gray-700">
                            <h4 class="text-sm font-medium text-blue-900 dark:text-white mb-4">Quick Actions</h4>
                            <div class="space-y-2">
                                <button type="button" onclick="exportAllData()" class="w-full text-left px-3 py-2 text-sm text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900 rounded-md transition-colors duration-150">
                                    Export All Alumni Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 max-w-4xl shadow-lg rounded-xl bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-blue-900 dark:text-white">Tambah Alumni Baru</h3>
                    <button type="button" onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="createForm" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama *</label>
                            <input type="text" name="nama" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password *</label>
                            <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                            <select name="status" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NIM</label>
                            <input type="text" name="nim" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jurusan</label>
                            <select name="jurusan" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Pilih Jurusan</option>
                                @foreach($jurusanList ?? [] as $jurusan)
                                    <option value="{{ $jurusan }}">{{ $jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun Masuk</label>
                            <input type="number" name="tahun_masuk" min="1900" max="{{ date('Y') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun Lulus</label>
                            <input type="number" name="tahun_lulus" min="1900" max="{{ date('Y') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">No. Telepon</label>
                            <input type="text" name="no_telepon" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">IPK</label>
                            <input type="number" step="0.01" min="0" max="4" name="ipk" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat Rumah</label>
                            <textarea name="alamat_rumah" rows="3" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">LinkedIn</label>
                            <input type="url" name="linkedin" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instagram</label>
                            <input type="text" name="instagram" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Alternatif</label>
                            <input type="email" name="email_alternatif" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" onclick="closeCreateModal()" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 max-w-4xl shadow-lg rounded-xl bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-blue-900 dark:text-white">Detail Alumni</h3>
                    <button type="button" onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="viewContent" class="space-y-6">
                    <div class="flex justify-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 max-w-4xl shadow-lg rounded-xl bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-blue-900 dark:text-white">Edit Alumni</h3>
                    <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="editForm" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div id="editContent">
                        <div class="flex justify-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" onclick="closeEditModal()" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-4">Hapus Alumni</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Apakah Anda yakin ingin menghapus alumni <span id="deleteAlumniName" class="font-semibold"></span>?
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 px-4 py-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add CSRF token meta tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        let currentAlumniId = null;

        // Create Modal Functions
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('createForm').reset();
            document.body.style.overflow = 'auto';
        }

        // Handle create form submission
        document.getElementById('createForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            submitBtn.disabled = true;
            submitBtn.textContent = 'Menyimpan...';

            fetch('{{ route('dashboard.member.alumni.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.id || data.success) {
                    closeCreateModal();
                    location.reload();
                } else {
                    alert('Error creating alumni: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating alumni');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });

        // View Modal Functions
        function openViewModal(alumniId) {
            currentAlumniId = alumniId;
            document.getElementById('viewModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            fetch(`{{ route('dashboard.member.alumni.show', ':id') }}`.replace(':id', alumniId))
                .then(response => response.json())
                .then(data => {
                    const profil = data.profil_alumni || {};
                    const content = `
                        <div class="bg-blue-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">${data.nama ? data.nama.charAt(0) : '-'}</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white">${data.nama || '-'}</h4>
                                    <p class="text-gray-600 dark:text-gray-400">${data.email || '-'}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                                        data.status === 'approved' ? 'bg-green-100 text-green-800' :
                                        data.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-red-100 text-red-800'
                                    } mt-2">
                                        ${data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : '-'}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIM</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.nim || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jurusan</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.jurusan || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Masuk</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.tahun_masuk || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Lulus</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.tahun_lulus || '-'}</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Telepon</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.no_telepon || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IPK</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.ipk || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">LinkedIn</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.linkedin || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Instagram</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.instagram || '-'}</p>
                                </div>
                            </div>

                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Rumah</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.alamat_rumah || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Alternatif</label>
                                    <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${profil.email_alternatif || '-'}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    document.getElementById('viewContent').innerHTML = content;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('viewContent').innerHTML = '<p class="text-red-500">Error loading data</p>';
                });
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Edit Modal Functions
        function openEditModal(alumniId) {
            currentAlumniId = alumniId;
            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            fetch(`{{ route('dashboard.member.alumni.show', ':id') }}`.replace(':id', alumniId))
                .then(response => response.json())
                .then(data => {
                    const profil = data.profil_alumni || {};
                    const jurusanOptions = `@foreach($jurusanList ?? [] as $jurusan)<option value="{{ $jurusan }}">{{ $jurusan }}</option>@endforeach`;
                    const content = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" value="${data.email || ''}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama</label>
                                <input type="text" name="nama" value="${data.nama || ''}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password (kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" name="password"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select name="status"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="pending" ${data.status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="approved" ${data.status === 'approved' ? 'selected' : ''}>Approved</option>
                                    <option value="rejected" ${data.status === 'rejected' ? 'selected' : ''}>Rejected</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NIM</label>
                                <input type="text" name="nim" value="${profil.nim || ''}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jurusan</label>
                                <select name="jurusan" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Pilih Jurusan</option>
                                    ${jurusanOptions.replace(/value=\"(.+?)\"/g, (m, v) => `value=\"${v}\"${profil.jurusan === v ? ' selected' : ''}`)}
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun Masuk</label>
                                <input type="number" name="tahun_masuk" value="${profil.tahun_masuk || ''}" min="1900" max="{{ date('Y') }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun Lulus</label>
                                <input type="number" name="tahun_lulus" value="${profil.tahun_lulus || ''}" min="1900" max="{{ date('Y') }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">No. Telepon</label>
                                <input type="text" name="no_telepon" value="${profil.no_telepon || ''}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">IPK</label>
                                <input type="number" step="0.01" name="ipk" value="${profil.ipk || ''}" min="0" max="4"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat Rumah</label>
                                <textarea name="alamat_rumah" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">${profil.alamat_rumah || ''}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">LinkedIn</label>
                                <input type="url" name="linkedin" value="${profil.linkedin || ''}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instagram</label>
                                <input type="text" name="instagram" value="${profil.instagram || ''}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Alternatif</label>
                                <input type="email" name="email_alternatif" value="${profil.email_alternatif || ''}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    `;
                    document.getElementById('editContent').innerHTML = content;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('editContent').innerHTML = '<p class="text-red-500">Error loading data</p>';
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Handle edit form submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            submitBtn.disabled = true;
            submitBtn.textContent = 'Menyimpan...';

            fetch(`{{ route('dashboard.member.alumni.update', ':id') }}`.replace(':id', currentAlumniId), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeEditModal();
                    location.reload();
                } else {
                    alert('Error updating alumni data: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating alumni data');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });

        // Delete Modal Functions
        function openDeleteModal(alumniId, alumniName) {
            currentAlumniId = alumniId;
            document.getElementById('deleteAlumniName').textContent = alumniName;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function confirmDelete() {
            const deleteBtn = document.querySelector('#deleteModal button[onclick="confirmDelete()"]');
            const originalText = deleteBtn.textContent;

            deleteBtn.disabled = true;
            deleteBtn.textContent = 'Menghapus...';

            fetch(`{{ route('dashboard.member.alumni.destroy', ':id') }}`.replace(':id', currentAlumniId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteModal();
                    location.reload();
                } else {
                    alert('Error deleting alumni: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting alumni');
            })
            .finally(() => {
                deleteBtn.disabled = false;
                deleteBtn.textContent = originalText;
            });
        }

        function exportAllData() {
            window.location.href = "{{ route('dashboard.member.alumni.exportAll') }}";
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const viewModal = document.getElementById('viewModal');
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');
            const createModal = document.getElementById('createModal');

            if (event.target === viewModal) {
                closeViewModal();
            }
            if (event.target === editModal) {
                closeEditModal();
            }
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
            if (event.target === createModal) {
                closeCreateModal();
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeViewModal();
                closeEditModal();
                closeDeleteModal();
                closeCreateModal();
            }
        });
    </script>
@endsection
