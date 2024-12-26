<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded-lg shadow-md w-full max-w-2xl">
        <h1 class="text-2xl font-bold mb-6 text-center">Profile Information</h1>
        <form action="/profile/store" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-300">NIM</label>
                    <input type="text" id="nim" name="nim" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-300">Nama</label>
                    <input type="text" id="nama" name="nama" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="jurusan" class="block text-sm font-medium text-gray-300">Jurusan</label>
                    <input type="text" id="jurusan" name="jurusan" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="tahun_masuk" class="block text-sm font-medium text-gray-300">Tahun Masuk</label>
                    <input type="number" id="tahun_masuk" name="tahun_masuk" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="tahun_lulus" class="block text-sm font-medium text-gray-300">Tahun Lulus</label>
                    <input type="number" id="tahun_lulus" name="tahun_lulus" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-300">No. Telepon</label>
                    <input type="tel" id="no_telepon" name="no_telepon" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input type="email" id="email" name="email" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div class="md:col-span-2">
                    <label for="alamat_rumah" class="block text-sm font-medium text-gray-300">Alamat Rumah</label>
                    <textarea id="alamat_rumah" name="alamat_rumah" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" rows="3"></textarea>
                </div>
                <div>
                    <label for="ipk" class="block text-sm font-medium text-gray-300">IPK</label>
                    <input type="number" id="ipk" name="ipk" step="0.01" min="0" max="4" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="linkedin" class="block text-sm font-medium text-gray-300">LinkedIn</label>
                    <input type="url" id="linkedin" name="linkedin" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="instagram" class="block text-sm font-medium text-gray-300">Instagram</label>
                    <input type="text" id="instagram" name="instagram" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="email_alternatif" class="block text-sm font-medium text-gray-300">Email Alternatif</label>
                    <input type="email" id="email_alternatif" name="email_alternatif" required class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                    Submit
                </button>
            </div>
        </form>
    </div>
</body>
</html>
