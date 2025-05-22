<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 text-gray-800 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white/90 backdrop-blur-lg p-8 rounded-2xl shadow-2xl w-full max-w-4xl border border-blue-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Profile Information</h1>
            <p class="text-gray-600 mt-2">Silakan lengkapi informasi profil Anda</p>
        </div>

        <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2 md:col-span-2">
                    <label for="foto" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                    @php
                    $fotoPreview = old('foto') ? asset('images/profil/' . old('foto')) : ($user->foto ? asset('images/profil/' . $user->foto) : null);
                    @endphp
                    @if($fotoPreview)
                    <img src="{{ $fotoPreview }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover mb-2">
                    @endif
                    <input type="file" id="foto" name="foto" accept="image/*" class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="nama" name="nama" required value="{{ old('nama', $user->nama) }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                @if($user->role === 'alumni')
                <div class="space-y-2">
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="nim" name="nim" required value="{{ old('nim', $profileData->nim ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                    <input type="text" id="jurusan" name="jurusan" required value="{{ old('jurusan', $profileData->jurusan ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="tahun_masuk" class="block text-sm font-medium text-gray-700">Tahun Masuk</label>
                    <input type="number" id="tahun_masuk" name="tahun_masuk" required value="{{ old('tahun_masuk', $profileData->tahun_masuk ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="tahun_lulus" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                    <input type="number" id="tahun_lulus" name="tahun_lulus" required value="{{ old('tahun_lulus', $profileData->tahun_lulus ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                    <input type="tel" id="no_telepon" name="no_telepon" required value="{{ old('no_telepon', $profileData->no_telepon ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="md:col-span-2 space-y-2">
                    <label for="alamat_rumah" class="block text-sm font-medium text-gray-700">Alamat Rumah</label>
                    <textarea id="alamat_rumah" name="alamat_rumah" required rows="3"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">{{ old('alamat_rumah', $profileData->alamat_rumah ?? '') }}</textarea>
                </div>
                <div class="space-y-2">
                    <label for="ipk" class="block text-sm font-medium text-gray-700">IPK</label>
                    <input type="number" id="ipk" name="ipk" step="0.01" min="0" max="4" required value="{{ old('ipk', $profileData->ipk ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="linkedin" class="block text-sm font-medium text-gray-700">LinkedIn</label>
                    <input type="url" id="linkedin" name="linkedin" value="{{ old('linkedin', $profileData->linkedin ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="instagram" class="block text-sm font-medium text-gray-700">Instagram</label>
                    <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $profileData->instagram ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="email_alternatif" class="block text-sm font-medium text-gray-700">Email Alternatif</label>
                    <input type="email" id="email_alternatif" name="email_alternatif" value="{{ old('email_alternatif', $profileData->email_alternatif ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                @elseif($user->role === 'admin')
                <div class="space-y-2">
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                    <input type="tel" id="no_telepon" name="no_telepon" required value="{{ old('no_telepon', $profileData->no_telepon ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" required value="{{ old('jabatan', $profileData->jabatan ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-white border border-blue-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                @endif
            </div>
            <div class="flex justify-end mt-8">
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg font-medium hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white transition duration-200 transform hover:scale-105">
                    Submit Profile
                </button>
            </div>
        </form>
    </div>
</body>

</html>