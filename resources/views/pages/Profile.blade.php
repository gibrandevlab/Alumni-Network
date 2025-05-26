@extends('layouts.index')

@section('title', 'Profile Information')

@section('content')
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="max-w-5xl mx-auto">
            <!-- Profile Header Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="md:flex">
                    <!-- Sticky Sidebar -->
                    <div id="read-fast-info" class="md:w-1/3 bg-gradient-to-br from-blue-500 to-indigo-600 text-white md:sticky md:top-0 md:self-start md:max-h-screen md:overflow-y-auto">
                        <div class="p-8">
                            <!-- Profile Photo -->
                            <div class="flex justify-center mb-6">
                                @php
                                    $fotoPreview = old('foto')
                                        ? asset('images/profil/' . old('foto'))
                                        : ($user->foto
                                            ? asset('images/profil/' . $user->foto)
                                            : asset('images/profil/default.png'));
                                @endphp
                                <div class="relative group">
                                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                        <img src="{{ $fotoPreview }}" alt="Profile Photo" class="w-full h-full object-cover">
                                    </div>
                                    <!-- Status indicator -->
                                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-400 rounded-full border-4 border-white flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Essential Info Only -->
                            <div class="text-center">
                                <h1 class="text-2xl font-bold mb-2">{{ $user->nama }}</h1>

                                <!-- Role Badge -->
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white mb-4">
                                    @if($user->role === 'alumni')
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                        </svg>
                                        Alumni
                                    @else
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                        </svg>
                                        Administrator
                                    @endif
                                </div>

                                <!-- Key Information Cards -->
                                @if ($user->role === 'alumni' && isset($profileData))
                                    <div class="space-y-4">
                                        <!-- Program Study -->
                                        @if(isset($profileData->jurusan))
                                        <div class="bg-white bg-opacity-10 rounded-lg p-3 backdrop-blur-sm">
                                            <div class="text-xs text-blue-100 uppercase tracking-wide font-semibold mb-1">Program</div>
                                            <div class="text-white font-medium text-sm">{{ $profileData->jurusan }}</div>
                                        </div>
                                        @endif

                                        <!-- Graduation Year -->
                                        @if(isset($profileData->tahun_lulus))
                                        <div class="bg-white bg-opacity-10 rounded-lg p-3 backdrop-blur-sm">
                                            <div class="text-xs text-blue-100 uppercase tracking-wide font-semibold mb-1">Graduated</div>
                                            <div class="text-white font-medium text-sm">{{ $profileData->tahun_lulus }}</div>
                                        </div>
                                        @endif

                                        <!-- GPA (only if excellent) -->
                                        @if(isset($profileData->ipk) && $profileData->ipk >= 3.5)
                                        <div class="bg-white bg-opacity-10 rounded-lg p-3 backdrop-blur-sm">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-xs text-blue-100 uppercase tracking-wide font-semibold">GPA</span>
                                                <span class="text-white font-bold">{{ $profileData->ipk }}</span>
                                            </div>
                                            <div class="w-full bg-blue-200 bg-opacity-30 rounded-full h-1.5">
                                                <div class="bg-white rounded-full h-1.5" style="width: {{ min(($profileData->ipk / 4) * 100, 100) }}%"></div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                @elseif($user->role === 'admin' && isset($profileData))
                                    <!-- Admin specific info -->
                                    @if(isset($profileData->jabatan))
                                    <div class="bg-white bg-opacity-10 rounded-lg p-3 backdrop-blur-sm">
                                        <div class="text-xs text-blue-100 uppercase tracking-wide font-semibold mb-1">Position</div>
                                        <div class="text-white font-medium text-sm">{{ $profileData->jabatan }}</div>
                                    </div>
                                    @endif
                                @endif

                                <!-- Contact Quick Access -->
                                @if(isset($profileData->no_telepon))
                                <div class="mt-6 pt-4 border-t border-white border-opacity-20">
                                    <a href="tel:{{ $profileData->no_telepon }}" class="inline-flex items-center text-white hover:text-blue-100 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $profileData->no_telepon }}</span>
                                    </a>
                                </div>
                                @endif

                                <!-- Profile Completion Indicator -->
                                @php
                                    $completionFields = ['nama', 'email'];
                                    if($user->role === 'alumni') {
                                        $completionFields = array_merge($completionFields, ['nim', 'jurusan', 'tahun_lulus', 'no_telepon']);
                                        $filledFields = 2; // nama, email always filled
                                        if(isset($profileData)) {
                                            if($profileData->nim) $filledFields++;
                                            if($profileData->jurusan) $filledFields++;
                                            if($profileData->tahun_lulus) $filledFields++;
                                            if($profileData->no_telepon) $filledFields++;
                                        }
                                        $completionPercentage = ($filledFields / 6) * 100;
                                    } else {
                                        $completionFields = array_merge($completionFields, ['no_telepon', 'jabatan']);
                                        $filledFields = 2; // nama, email always filled
                                        if(isset($profileData)) {
                                            if($profileData->no_telepon) $filledFields++;
                                            if($profileData->jabatan) $filledFields++;
                                        }
                                        $completionPercentage = ($filledFields / 4) * 100;
                                    }
                                @endphp

                                <div class="mt-6 pt-4 border-t border-white border-opacity-20">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs text-blue-100 uppercase tracking-wide font-semibold">Profile</span>
                                        <span class="text-white font-bold text-sm">{{ round($completionPercentage) }}%</span>
                                    </div>
                                    <div class="w-full bg-blue-200 bg-opacity-30 rounded-full h-2">
                                        <div class="bg-white rounded-full h-2 transition-all duration-300" style="width: {{ $completionPercentage }}%"></div>
                                    </div>
                                    @if($completionPercentage < 100)
                                    <p class="text-xs text-blue-100 mt-2">Complete your profile to unlock all features</p>
                                    @else
                                    <p class="text-xs text-blue-100 mt-2">Profile completed! 🎉</p>
                                    @endif
                                </div>

                                <!-- Quick Actions -->
                                <div class="mt-6 pt-4 border-t border-white border-opacity-20">
                                    <div class="space-y-2">
                                        <button onclick="scrollToSection('basic-info')" class="w-full text-left px-3 py-2 text-sm text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors">
                                            📝 Basic Information
                                        </button>
                                        @if($user->role === 'alumni')
                                        <button onclick="scrollToSection('academic-info')" class="w-full text-left px-3 py-2 text-sm text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors">
                                            🎓 Academic Information
                                        </button>
                                        <button onclick="scrollToSection('contact-info')" class="w-full text-left px-3 py-2 text-sm text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors">
                                            📞 Contact Information
                                        </button>
                                        @endif
                                        <button onclick="scrollToSection('password-section')" class="w-full text-left px-3 py-2 text-sm text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors">
                                            🔒 Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scrollable Form Area -->
                    <div class="md:w-2/3 md:max-h-screen md:overflow-y-auto" id="store-data">
                        <div class="p-8">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-800">Profile Information</h2>
                                <div class="text-sm text-gray-500">Last updated: {{ $user->updated_at->format('d M Y') }}</div>
                            </div>

                            <p class="text-gray-600 mb-8">Please complete your profile information below. This information will
                                be used to connect you with other alumni and opportunities.</p>

                            <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Photo Upload Section -->
                                <div class="mb-8">
                                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Profile
                                        Photo</label>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-4">
                                            <div
                                                class="w-16 h-16 rounded-full overflow-hidden bg-gray-100 border border-gray-200">
                                                <img src="{{ $fotoPreview }}" alt="Current profile photo"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                        <div class="flex-grow">
                                            <input type="file" id="foto" name="foto" accept="image/*" class="hidden"
                                                onchange="updateFileLabel(this)">
                                            <label for="foto"
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer">
                                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Change photo
                                            </label>
                                            <p id="fileLabel" class="mt-1 text-sm text-gray-500">No file selected</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- User Table Fields (Readonly except password) -->
                                <div class="mb-8">
                                    <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2 mb-4">User
                                        Account Data</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="role"
                                                class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                            <input type="text" id="role" name="role" value="{{ $user->role }}"
                                                readonly
                                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-100 shadow-sm">
                                        </div>
                                        <div>
                                            <label for="status"
                                                class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                            <input type="text" id="status" name="status" value="{{ $user->status }}"
                                                readonly
                                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-100 shadow-sm">
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Section -->
                                <div class="mb-8" id="password-section">
                                    <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2 mb-4">Change
                                        Password</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New
                                                Password</label>
                                            <input type="password" id="password" name="password"
                                                autocomplete="new-password"
                                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                        </div>
                                        <div>
                                            <label for="password_confirmation"
                                                class="block text-sm font-medium text-gray-700 mb-1">Confirm New
                                                Password</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                autocomplete="new-password"
                                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Leave blank if you do not want to change the
                                        password.</p>
                                </div>

                                <!-- Form Fields -->
                                <div class="space-y-6">
                                    <!-- Basic Information Section -->
                                    <div id="basic-info">
                                        <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2 mb-4">
                                            Basic Information</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="nama"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                                <input type="text" id="nama" name="nama" required
                                                    value="{{ old('nama', $user->nama) }}" readonly
                                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-100 shadow-sm">
                                            </div>

                                            <div>
                                                <label for="email"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                                <input type="email" id="email" name="email" required
                                                    value="{{ old('email', $user->email) }}" readonly
                                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-100 shadow-sm">
                                            </div>

                                            @if ($user->role === 'alumni')
                                                <div>
                                                    <label for="nim"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Student ID
                                                        (NIM)</label>
                                                    <input type="text" id="nim" name="nim" required
                                                        value="{{ old('nim', $profileData->nim ?? '') }}"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                </div>

                                                <div>
                                                    <label for="no_telepon"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Phone
                                                        Number</label>
                                                    <input type="tel" id="no_telepon" name="no_telepon" required
                                                        value="{{ old('no_telepon', $profileData->no_telepon ?? '') }}"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                </div>
                                            @elseif($user->role === 'admin')
                                                <div>
                                                    <label for="no_telepon"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Phone
                                                        Number</label>
                                                    <input type="tel" id="no_telepon" name="no_telepon" required
                                                        value="{{ old('no_telepon', $profileData->no_telepon ?? '') }}"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                </div>

                                                <div>
                                                    <label for="jabatan"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                                                    <input type="text" id="jabatan" name="jabatan" required
                                                        value="{{ old('jabatan', $profileData->jabatan ?? '') }}"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($user->role === 'alumni')
                                        <!-- Academic Information Section -->
                                        <div id="academic-info">
                                            <h3
                                                class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2 mb-4">
                                                Academic Information</h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div>
                                                    <label for="jurusan"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Major/Department</label>
                                                    <input type="text" id="jurusan" name="jurusan" required
                                                        value="{{ old('jurusan', $profileData->jurusan ?? '') }}"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                </div>

                                                <div>
                                                    <label for="ipk"
                                                        class="block text-sm font-medium text-gray-700 mb-1">GPA</label>
                                                    <input type="number" id="ipk" name="ipk" step="0.01"
                                                        min="0" max="4" required
                                                        value="{{ old('ipk', $profileData->ipk ?? '') }}"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                </div>

                                                <div>
                                                    <label for="tahun_masuk"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Entry
                                                        Year</label>
                                                    <input type="number" id="tahun_masuk" name="tahun_masuk" required
                                                        value="{{ old('tahun_masuk', $profileData->tahun_masuk ?? '') }}"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                </div>

                                                <div>
                                                    <label for="tahun_lulus"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Graduation
                                                        Year</label>
                                                    <input type="number" id="tahun_lulus" name="tahun_lulus" required
                                                        value="{{ old('tahun_lulus', $profileData->tahun_lulus ?? '') }}"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contact Information Section -->
                                        <div id="contact-info">
                                            <h3
                                                class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2 mb-4">
                                                Contact Information</h3>
                                            <div class="grid grid-cols-1 gap-6">
                                                <div>
                                                    <label for="alamat_rumah"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Home
                                                        Address</label>
                                                    <textarea id="alamat_rumah" name="alamat_rumah" required rows="3"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('alamat_rumah', $profileData->alamat_rumah ?? '') }}</textarea>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                                    <div>
                                                        <label for="linkedin"
                                                            class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <svg class="h-5 w-5 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                                                </svg>
                                                            </div>
                                                            <input type="url" id="linkedin" name="linkedin"
                                                                value="{{ old('linkedin', $profileData->linkedin ?? '') }}"
                                                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="instagram"
                                                            class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <svg class="h-5 w-5 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                                </svg>
                                                            </div>
                                                            <input type="text" id="instagram" name="instagram"
                                                                value="{{ old('instagram', $profileData->instagram ?? '') }}"
                                                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="email_alternatif"
                                                            class="block text-sm font-medium text-gray-700 mb-1">Alternative
                                                            Email</label>
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <svg class="h-5 w-5 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                                    </path>
                                                                    <polyline points="22,6 12,13 2,6"></polyline>
                                                                </svg>
                                                            </div>
                                                            <input type="email" id="email_alternatif"
                                                                name="email_alternatif"
                                                                value="{{ old('email_alternatif', $profileData->email_alternatif ?? '') }}"
                                                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Submit Button -->
                                    <div class="pt-5 border-t border-gray-200">
                                        <div class="flex justify-end">
                                            <button type="button" onclick="window.history.back()"
                                                class="mr-4 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-md shadow-sm text-sm font-medium hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                                Save Profile
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom scrollbar for better UX */
        #store-data::-webkit-scrollbar {
            width: 6px;
        }

        #store-data::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #store-data::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        #store-data::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        #read-fast-info::-webkit-scrollbar {
            width: 4px;
        }

        #read-fast-info::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        #read-fast-info::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        #read-fast-info::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Smooth scroll behavior */
        #store-data {
            scroll-behavior: smooth;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #read-fast-info {
                position: static !important;
                max-height: none !important;
                overflow-y: visible !important;
            }

            #store-data {
                max-height: none !important;
                overflow-y: visible !important;
            }
        }
    </style>

    <script>
        function updateFileLabel(input) {
            const fileLabel = document.getElementById('fileLabel');
            if (input.files && input.files[0]) {
                fileLabel.textContent = input.files[0].name;

                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImages = document.querySelectorAll(
                        'img[alt="Current profile photo"], img[alt="Profile Photo"]');
                    previewImages.forEach(img => {
                        img.src = e.target.result;
                    });
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                fileLabel.textContent = 'No file selected';
            }
        }

        function scrollToSection(sectionId) {
            const storeDataContainer = document.getElementById('store-data');
            const targetSection = document.getElementById(sectionId);

            if (targetSection && storeDataContainer) {
                const containerRect = storeDataContainer.getBoundingClientRect();
                const targetRect = targetSection.getBoundingClientRect();
                const scrollTop = storeDataContainer.scrollTop;

                const targetPosition = scrollTop + targetRect.top - containerRect.top - 20; // 20px offset

                storeDataContainer.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        }

        // Add scroll indicator for active section
        document.addEventListener('DOMContentLoaded', function() {
            const storeDataContainer = document.getElementById('store-data');
            const quickActionButtons = document.querySelectorAll('#read-fast-info button[onclick^="scrollToSection"]');

            if (storeDataContainer && quickActionButtons.length > 0) {
                storeDataContainer.addEventListener('scroll', function() {
                    const sections = ['basic-info', 'academic-info', 'contact-info', 'password-section'];
                    let activeSection = null;

                    sections.forEach(sectionId => {
                        const section = document.getElementById(sectionId);
                        if (section) {
                            const rect = section.getBoundingClientRect();
                            const containerRect = storeDataContainer.getBoundingClientRect();

                            if (rect.top <= containerRect.top + 100 && rect.bottom >= containerRect.top + 100) {
                                activeSection = sectionId;
                            }
                        }
                    });

                    // Update active button styling
                    quickActionButtons.forEach(button => {
                        const buttonSectionId = button.getAttribute('onclick').match(/scrollToSection$$'(.+?)'$$/)[1];
                        if (buttonSectionId === activeSection) {
                            button.classList.add('bg-white', 'bg-opacity-20', 'text-white');
                            button.classList.remove('text-blue-100');
                        } else {
                            button.classList.remove('bg-white', 'bg-opacity-20', 'text-white');
                            button.classList.add('text-blue-100');
                        }
                    });
                });
            }
        });
    </script>
@endsection
