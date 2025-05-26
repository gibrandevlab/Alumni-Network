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
        @if ($alumniProfiles)
            @foreach ($alumniProfiles as $alumni)
                <tr class="bg-white dark:bg-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-5 py-4 border-b border-gray-200 text-sm text-black dark:text-black">
                        {{ ($alumniProfiles->currentPage() - 1) * $alumniProfiles->perPage() + $loop->iteration }}</td>
                    <td class="px-5 py-4 border-b border-gray-200 text-sm text-black dark:text-black">
                        {{ $alumni->profilAlumni->nim ?? 'N/A' }}</td>
                    <td class="px-5 py-4 border-b border-gray-200 text-sm text-black dark:text-black">
                        {{ $alumni->nama }}</td>
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
        @else
            <tr>
                <td colspan="5" class="text-center">No data available</td>
            </tr>
        @endif
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
<div id="editModal" class="hidden fixed inset-0 items-center justify-center z-50 backdrop-blur-sm shadow-xl">
    <div class="dark:bg-gray-800 p-8 rounded-lg text-center max-w-sm w-full">
        <h2 class="text-lg font-semibold mb-6 text-white">Edit Alumni</h2>
        <form id="editForm">
            <input type="hidden" name="id">
            <input type="text" name="nama" placeholder="Name" class="w-full mb-4 p-2 rounded">
            <input type="email" name="email" placeholder="Email" class="w-full mb-4 p-2 rounded">
            <input type="text" name="nim" placeholder="NIM" class="w-full mb-4 p-2 rounded">
            <input type="text" name="jurusan" placeholder="Jurusan" class="w-full mb-4 p-2 rounded">
            <input type="number" name="tahun_masuk" placeholder="Tahun Masuk" class="w-full mb-4 p-2 rounded">
            <input type="number" name="tahun_lulus" placeholder="Tahun Lulus" class="w-full mb-4 p-2 rounded">
            <input type="text" name="no_telepon" placeholder="No Telepon" class="w-full mb-4 p-2 rounded">
            <input type="text" name="alamat_rumah" placeholder="Alamat Rumah" class="w-full mb-4 p-2 rounded">
            <input type="number" step="0.01" name="ipk" placeholder="IPK" class="w-full mb-4 p-2 rounded">
            <input type="url" name="linkedin" placeholder="LinkedIn" class="w-full mb-4 p-2 rounded">
            <input type="text" name="instagram" placeholder="Instagram" class="w-full mb-4 p-2 rounded">
            <input type="email" name="email_alternatif" placeholder="Email Alternatif" class="w-full mb-4 p-2 rounded">
            <button type="submit"
                class="bg-yellow-500 text-white px-5 py-2 rounded-lg hover:bg-yellow-600">Save</button>
            <button type="button" onclick="closeEditModal()"
                class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600">Cancel</button>
        </form>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="hidden fixed inset-0 items-center justify-center z-50 backdrop-blur-sm shadow-xl">
    <div class="dark:bg-gray-800 p-8 rounded-lg text-center max-w-sm w-full">
        <h2 class="text-lg font-semibold mb-6 text-white">Add Alumni</h2>
        <form id="addForm">
            <input type="text" name="nama" placeholder="Name" class="w-full mb-4 p-2 rounded">
            <input type="email" name="email" placeholder="Email" class="w-full mb-4 p-2 rounded">
            <input type="password" name="password" placeholder="Password" class="w-full mb-4 p-2 rounded">
            <input type="text" name="nim" placeholder="NIM" class="w-full mb-4 p-2 rounded">
            <input type="text" name="jurusan" placeholder="Jurusan" class="w-full mb-4 p-2 rounded">
            <input type="number" name="tahun_masuk" placeholder="Tahun Masuk" class="w-full mb-4 p-2 rounded">
            <input type="number" name="tahun_lulus" placeholder="Tahun Lulus" class="w-full mb-4 p-2 rounded">
            <input type="text" name="no_telepon" placeholder="No Telepon" class="w-full mb-4 p-2 rounded">
            <input type="text" name="alamat_rumah" placeholder="Alamat Rumah" class="w-full mb-4 p-2 rounded">
            <input type="number" step="0.01" name="ipk" placeholder="IPK" class="w-full mb-4 p-2 rounded">
            <input type="url" name="linkedin" placeholder="LinkedIn" class="w-full mb-4 p-2 rounded">
            <input type="text" name="instagram" placeholder="Instagram" class="w-full mb-4 p-2 rounded">
            <input type="email" name="email_alternatif" placeholder="Email Alternatif" class="w-full mb-4 p-2 rounded">
            <button type="submit"
                class="bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600">Add</button>
            <button type="button" onclick="closeAddModal()"
                class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600">Cancel</button>
        </form>
    </div>
</div>

<script>
    async function showDetail(id) {
        try {
            const response = await fetch(`/dashboard/member/alumni/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            const data = await response.json();

            if (response.ok) {
                let details = `ID: ${data.id}\n`;
                details += `Nama: ${data.nama}\n`;
                details += `Email: ${data.email}\n`;
                details += `Role: ${data.role}\n`;
                details += `Status: ${data.status}\n`;
                details += `NIM: ${data.profilAlumni?.nim || 'N/A'}\n`;
                details += `Jurusan: ${data.profilAlumni?.jurusan || 'N/A'}\n`;
                details += `Tahun Masuk: ${data.profilAlumni?.tahun_masuk || 'N/A'}\n`;
                details += `Tahun Lulus: ${data.profilAlumni?.tahun_lulus || 'N/A'}\n`;
                details += `No Telepon: ${data.profilAlumni?.no_telepon || 'N/A'}\n`;
                details += `Alamat Rumah: ${data.profilAlumni?.alamat_rumah || 'N/A'}\n`;
                details += `IPK: ${data.profilAlumni?.ipk || 'N/A'}\n`;
                details += `LinkedIn: ${data.profilAlumni?.linkedin || 'N/A'}\n`;
                details += `Instagram: ${data.profilAlumni?.instagram || 'N/A'}\n`;
                details += `Email Alternatif: ${data.profilAlumni?.email_alternatif || 'N/A'}\n`;

                alert(details);
            } else {
                alert('Failed to fetch details.');
            }
        } catch (error) {
            console.error('Error fetching details:', error);
            alert('Failed to fetch details.');
        }
    }

    async function showEditModal(id) {
        try {
            const response = await fetch(`/dashboard/member/alumni/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            const data = await response.json();

            if (response.ok) {
                const form = document.getElementById('editForm');
                form.id.value = data.id;
                form.nama.value = data.nama;
                form.email.value = data.email;
                form.nim.value = data.profilAlumni.nim;
                form.jurusan.value = data.profilAlumni.jurusan;
                form.tahun_masuk.value = data.profilAlumni.tahun_masuk;
                form.tahun_lulus.value = data.profilAlumni.tahun_lulus;
                form.no_telepon.value = data.profilAlumni.no_telepon;
                form.alamat_rumah.value = data.profilAlumni.alamat_rumah;
                form.ipk.value = data.profilAlumni.ipk;
                form.linkedin.value = data.profilAlumni.linkedin;
                form.instagram.value = data.profilAlumni.instagram;
                form.email_alternatif.value = data.profilAlumni.email_alternatif;
                openModal('editModal');
            } else {
                alert('Failed to fetch data for edit.');
            }
        } catch (error) {
            console.error('Error fetching data for edit:', error);
            alert('Failed to fetch data for edit.');
        }
    }

    async function deleteDetail(id) {
        if (confirm('Are you sure you want to delete this record?')) {
            try {
                const response = await fetch(`/dashboard/member/alumni/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to delete record.');
                }
            } catch (error) {
                console.error('Error deleting record:', error);
                alert('Failed to delete record.');
            }
        }
    }
</script>
