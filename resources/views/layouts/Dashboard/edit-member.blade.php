<div id="editModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-4xl mx-auto">
        <h3 class="text-2xl font-semibold mb-4 text-white dark:text-gray-200">Edit Data Alumni</h3>
        <form id="editForm" action="{{ route('alumni.update', ':id') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="hidden" id="editId" name="id">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="editNama" class="block text-white dark:text-gray-300">Nama</label>
                    <input type="text" id="editNama" name="nama"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editTahunMasuk" class="block text-white dark:text-gray-300">Tahun Masuk</label>
                    <input type="number" id="editTahunMasuk" name="tahun_masuk"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editTahunLulus" class="block text-white dark:text-gray-300">Tahun Lulus</label>
                    <input type="number" id="editTahunLulus" name="tahun_lulus"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editNoTelepon" class="block text-white dark:text-gray-300">No. Telepon</label>
                    <input type="text" id="editNoTelepon" name="no_telepon"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editEmail" class="block text-white dark:text-gray-300">Email</label>
                    <input type="email" id="editEmail" name="email"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editAlamatRumah" class="block text-white dark:text-gray-300">Alamat Rumah</label>
                    <input type="text" id="editAlamatRumah" name="alamat_rumah"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editIpk" class="block text-white dark:text-gray-300">IPK</label>
                    <input type="number" id="editIpk" name="ipk" step="0.01"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editLinkedIn" class="block text-white dark:text-gray-300">LinkedIn</label>
                    <input type="text" id="editLinkedIn" name="linkedin"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editInstagram" class="block text-white dark:text-gray-300">Instagram</label>
                    <input type="text" id="editInstagram" name="instagram"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editEmailAlternatif" class="block text-white dark:text-gray-300">Email
                        Alternatif</label>
                    <input type="email" id="editEmailAlternatif" name="email_alternatif"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeModal('editModal')"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-800">Batal</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800">Simpan</button>
            </div>
        </form>
    </div>
</div>
