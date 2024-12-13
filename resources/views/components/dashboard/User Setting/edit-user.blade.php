<div id="editModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 backdrop-blur-sm shadow">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-4xl mx-auto">
        <h3 class="text-2xl font-semibold mb-4 text-white dark:text-gray-200">Edit Data Alumni</h3>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="hidden" id="editId" name="id">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="editEmail" class="block text-white dark:text-gray-300">Email</label>
                    <input type="email" id="editEmail" name="email"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editPassword" class="block text-white dark:text-gray-300">Password</label>
                    <input type="password" id="editPassword" name="password"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                </div>

                <div>
                    <label for="editRole" class="block text-white dark:text-gray-300">Role</label>
                    <select id="editRole" name="role"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                        <option value="admin">Admin</option>
                        <option value="alumni">Alumni</option>
                        <option value="pencari_kerja">Pencari Kerja</option>
                    </select>
                </div>

                <div>
                    <label for="editStatus" class="block text-white dark:text-gray-300">Status</label>
                    <select id="editStatus" name="status"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
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

