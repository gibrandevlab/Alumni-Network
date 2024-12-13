<table class="min-w-full leading-normal">
    <thead>
    <tr>
        <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">No</th>
        <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">NIM</th>
        <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">Nama</th>
        <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">Aksi</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($alumniProfiles as $alumni)
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" data-id="{{ $alumni->id }}">
                <td class="px-5 py-4 border-b border-gray-200 text-sm text-white">{{ ($alumniProfiles->currentPage() - 1) * $alumniProfiles->perPage() + $loop->iteration }}</td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm text-white nim-cell">{{ $alumni->nim }}</td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm text-white nama-cell">{{ $alumni->nama }}</td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm space-x-2">
                    <button onclick="showDetail({{ $alumni->id }})" class="text-blue-500 hover:text-blue-700 font-semibold">View</button>
                    <button onclick="showEditModal({{ $alumni->id }})" class="text-yellow-500 hover:text-yellow-700 font-semibold">Edit</button>
                    <button onclick="deleteDetail({{ $alumni->id }})" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal Konfirmasi -->
<div id="confirmModal" class="hidden fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm shadow-xl">
    <div class="dark:bg-gray-800 p-8 rounded-lg text-center max-w-sm w-full">
        <h2 class="text-lg font-semibold mb-6 text-white">Anda yakin ingin menghapus data ini?</h2>
        <div class="flex justify-center gap-6">
            <button id="confirmDeleteBtn" class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">Hapus</button>
            <button id="cancelDeleteBtn" class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Batal</button>
        </div>
    </div>
</div>
