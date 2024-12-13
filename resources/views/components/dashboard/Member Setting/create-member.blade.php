
<div id="createModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 backdrop-blur-sm shadow-">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-4xl mx-auto">
        <h3 class="text-2xl font-semibold mb-4 text-white dark:text-gray-200">Tambah Data Alumni</h3>
        <form id="createForm" action="{{ route('alumni.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="createUserId" class="block text-white dark:text-gray-300">User ID</label>
                    <select id="createUserId" name="user_id" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                        <option value="">Pilih Pengguna</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->id }} - {{ $user->email }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="createNim" class="block text-white dark:text-gray-300">NIM</label>
                    <input type="text" id="createNim" name="nim" required pattern="[0-9]{8}" title="Masukkan NIM dengan 8 digit angka"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan NIM Anda">
                    @error('nim')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="createNama" class="block text-white dark:text-gray-300">Nama</label>
                    <input type="text" id="createNama" name="nama" required pattern="[a-zA-Z ]{1,50}" title="Masukkan Nama Lengkap dengan 1-50 karakter"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan Nama Lengkap">
                    @error('nama')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="createTahunMasuk" class="block text-white dark:text-gray-300">Tahun Masuk</label>
                    <input type="number" id="createTahunMasuk" name="tahun_masuk" required min="1900" max="{{ date('Y') }}" step="1"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Tahun Masuk (e.g., 2020)">
                    @error('tahun_masuk')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="createTahunLulus" class="block text-white dark:text-gray-300">Tahun Lulus</label>
                    <input type="number" id="createTahunLulus" name="tahun_lulus" required min="1900" max="{{ date('Y') }}" step="1"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Tahun Lulus (e.g., 2024)">
                    @error('tahun_lulus')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="createNoTelepon" class="block text-white dark:text-gray-300">No. Telepon</label>
                    <input type="text" id="createNoTelepon" name="no_telepon" required pattern="[0-9]{8,12}" title="Masukkan No. Telepon dengan 8-12 digit angka"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan No. Telepon">
                    @error('no_telepon')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="createEmail" class="block text-white dark:text-gray-300">Email</label>
                    <input type="email" id="createEmail" name="email" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="example@example.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="createIpk" class="block text-white dark:text-gray-300">IPK</label>
                    <input type="number" id="createIpk" name="ipk" step="0.01" min="0" max="4" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan IPK (e.g., 3.50)">
                    @error('ipk')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeModal('createModal')"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-800">Batal</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-800">Simpan</button>
            </div>
        </form>
    </div>
</div>

