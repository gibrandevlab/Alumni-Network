<div id="detailModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 backdrop-blur-sm shadow-">
    <div class="dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto">
        <h3 class="text-2xl font-semibold mb-4 text-gray-800">Detail Data Alumni</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full dark:bg-gray-800 rounded-lg">
                <tbody id="alumniDetail" class="text-gray-700">
                    <!-- Konten detail data akan diisi melalui JavaScript -->
                </tbody>
            </table>
        </div>
        <div class="flex justify-end mt-6">
            <button onclick="closeModal('detailModal')" class="px-5 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-800 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-300">Tutup</button>
        </div>
    </div>
</div>
