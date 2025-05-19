<table class="min-w-full leading-normal border-amber-500 shadow-md">
    <thead>
        <tr>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-300 text-black dark:text-black text-left text-sm uppercase font-semibold">
                No</th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-300 text-black dark:text-black text-left text-sm uppercase font-semibold">
                NIM</th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-300 text-black dark:text-black text-left text-sm uppercase font-semibold">
                Nama</th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-300 text-black dark:text-black text-left text-sm uppercase font-semibold">
                Status</th>
            <th scope="col"
                class="px-5 py-3 bg-gray-100 dark:bg-gray-300 text-black dark:text-black text-left text-sm uppercase font-semibold">
                Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alumniProfiles as $alumni)
            <tr class="bg-white dark:bg-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <td class="px-5 py-4 border-b border-gray-200 text-sm text-black dark:text-black">
                    {{ ($alumniProfiles->currentPage() - 1) * $alumniProfiles->perPage() + $loop->iteration }}</td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm text-black dark:text-black">{{ $alumni->nim }}</td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm text-black dark:text-black">{{ $alumni->nama }}</td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm text-black dark:text-black">
                    <span
                        class="px-2 py-1 rounded-full text-black {{ $alumni->status === 'approved' ? 'bg-green-500' : ($alumni->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                        {{ ucfirst($alumni->status) }}
                    </span>
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm space-x-2 text-black dark:text-black">
                    <button onclick="showDetail({{ $alumni->id }})"
                        class="text-blue-500 hover:text-blue-700 font-semibold">View</button>
                    <button onclick="showEditModal({{ $alumni->id }})"
                        class="text-yellow-500 hover:text-yellow-700 font-semibold">Edit</button>
                    <button onclick="deleteDetail({{ $alumni->id }})"
                        class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<button onclick="showAddModal()"
    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">Add
    Data</button>
<!-- Modal Konfirmasi -->
<div id="confirmModal" class="hidden fixed inset-0 items-center justify-center z-50 backdrop-blur-sm shadow-xl">
    <div class="dark:bg-gray-800 p-8 rounded-lg text-center max-w-sm w-full">
        <h2 class="text-lg font-semibold mb-6 text-white">Anda yakin ingin menghapus data ini?</h2>
        <div class="flex justify-center gap-6">
            <button id="confirmDeleteBtn"
                class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">Hapus</button>
            <button id="cancelDeleteBtn"
                class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Batal</button>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="hidden fixed inset-0 items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-lg font-semibold mb-4">Detail Alumni</h2>
        <p><strong>NIM:</strong> <span id="viewNim"></span></p>
        <p><strong>Nama:</strong> <span id="viewNama"></span></p>
        <button onclick="closeModal('viewModal')" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Close</button>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-lg font-semibold mb-4">Edit Alumni</h2>
        <form id="editForm">
            <label for="editNim" class="block mb-2">NIM</label>
            <input type="text" id="editNim" name="nim" class="w-full mb-4 p-2 border rounded">

            <label for="editNama" class="block mb-2">Nama</label>
            <input type="text" id="editNama" name="nama" class="w-full mb-4 p-2 border rounded">

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
            <button type="button" onclick="closeModal('editModal')"
                class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        </form>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="hidden fixed inset-0 items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-lg font-semibold mb-4">Add Alumni</h2>
        <form id="addForm">
            <label for="addNim" class="block mb-2">NIM</label>
            <input type="text" id="addNim" name="nim" class="w-full mb-4 p-2 border rounded">

            <label for="addNama" class="block mb-2">Nama</label>
            <input type="text" id="addNama" name="nama" class="w-full mb-4 p-2 border rounded">

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add</button>
            <button type="button" onclick="closeModal('addModal')"
                class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        </form>
    </div>
</div>

<script>
    async function showDetail(id) {
        try {
            const response = await fetch(`/alumni/${id}`);
            const data = await response.json();

            if (response.ok) {
                document.getElementById('viewNim').textContent = data.nim;
                document.getElementById('viewNama').textContent = data.nama;
                openModal('viewModal');
            } else {
                alert(data.error || 'Failed to fetch details.');
            }
        } catch (error) {
            console.error('Error fetching details:', error);
            alert('Failed to fetch details.');
        }
    }

    async function showEditModal(id) {
        try {
            const response = await fetch(`/alumni/${id}`);
            const data = await response.json();

            if (response.ok) {
                document.getElementById('editNim').value = data.nim;
                document.getElementById('editNama').value = data.nama;
                document.getElementById('editForm').onsubmit = async function(e) {
                    e.preventDefault();
                    await updateAlumni(id);
                };
                openModal('editModal');
            } else {
                alert(data.error || 'Failed to fetch data for edit.');
            }
        } catch (error) {
            console.error('Error fetching data for edit:', error);
            alert('Failed to fetch data for edit.');
        }
    }

    async function updateAlumni(id) {
        try {
            const formData = new FormData(document.getElementById('editForm'));
            const response = await fetch(`/alumni/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            });

            if (response.ok) {
                alert('Data updated successfully');
                closeModal('editModal');
                location.reload();
            } else {
                const data = await response.json();
                alert(data.error || 'Failed to update data.');
            }
        } catch (error) {
            console.error('Error updating data:', error);
            alert('Failed to update data.');
        }
    }

    document.getElementById('addForm').onsubmit = async function(e) {
        e.preventDefault();
        try {
            const formData = new FormData(document.getElementById('addForm'));
            const response = await fetch('/alumni', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            });

            if (response.ok) {
                alert('Data added successfully');
                closeModal('addModal');
                location.reload();
            } else {
                const data = await response.json();
                alert(data.error || 'Failed to add data.');
            }
        } catch (error) {
            console.error('Error adding data:', error);
            alert('Failed to add data.');
        }
    };

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function showAddModal() {
        openModal('addModal');
    }

    function deleteDetail(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            alert(`Deleted ID: ${id}`);
        }
    }
</script>
