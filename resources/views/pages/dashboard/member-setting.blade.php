@extends('layouts.Dashboard.dashboard')

@section('title', 'Admin - SITRA BSI')

@section('content')
    @if ($peranPengguna == 'admin')
        <div
            class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-800 text-black dark:text-white">
            {{-- Menu Admin --}}
            @include('layouts.Dashboard.navbaratas')
            @include('layouts.Dashboard.sidebarkiri')

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64 p-6">
                {{-- Tabel Pengguna --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <div class="flex justify-end mb-4">
                        <button onclick="showCreateModal()"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-700">Tambah Alumni</button>
                    </div>
                    <h2 class="text-2xl font-semibold mb-4 dark:bg-gray-800 dark:text-gray-200">Data Alumni</h2>

                    @include('components.dashboard.Member Setting.table-member', ['alumniProfiles' => $alumniProfiles])

                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-4">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing {{ $alumniProfiles->firstItem() }} to {{ $alumniProfiles->lastItem() }} of
                        {{ $alumniProfiles->total() }} results
                    </div>
                    <div>
                        {{ $alumniProfiles->links('vendor.pagination.tailwind') }} <!-- Menampilkan pagination -->
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Pop-Up untuk Detail Data --}}
    @include('components.dashboard.Member Setting.detail-member')

    {{-- Modal Pop-Up untuk Edit Data --}}
    @include('components.dashboard.Member Setting.edit-member')

    {{-- Modal Pop-Up untuk Tambah Data --}}
    @include('components.dashboard.Member Setting.create-member')

@endsection

<script>
    // Function to show modal and reset the form
    function showCreateModal() {
        const modal = document.getElementById('createModal');
        modal.classList.remove('hidden');
        document.getElementById('createForm').reset();
    }

    // Function to close modal and reset forms if necessary
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        if (modalId === 'editModal') document.getElementById('editForm').reset();
        if (modalId === 'createModal') document.getElementById('createForm').reset();
    }

    // Function to fetch data from API
    async function fetchData(url) {
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Data tidak ditemukan');
            return await response.json();
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengambil data.');
        }
    }

    // Function to display detailed alumni data in modal
    async function showDetail(id) {
        try {
            const data = await fetchData(`/alumni/${id}`);
            const fields = [
                { label: 'NIM', value: data.nim },
                { label: 'Nama', value: data.nama },
                { label: 'Tahun Masuk', value: data.tahun_masuk },
                { label: 'Tahun Lulus', value: data.tahun_lulus },
                { label: 'No. Telepon', value: data.no_telepon },
                { label: 'Email', value: data.email },
                { label: 'Alamat Rumah', value: data.alamat_rumah },
                { label: 'IPK', value: data.ipk },
                { label: 'LinkedIn', value: data.linkedin },
                { label: 'Instagram', value: data.instagram },
                { label: 'Email Alternatif', value: data.email_alternatif }
            ];

            document.getElementById('alumniDetail').innerHTML = fields
                .map(field => `
                    <tr class="border-b">
                        <td class="py-2 px-4 font-medium text-white">${field.label}:</td>
                        <td class="py-2 px-4 text-white">${field.value ?? '-'}</td>
                    </tr>
                `).join('');
            document.getElementById('detailModal').classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengambil data.');
        }
    }

    // Function to show edit modal with prefilled data
    async function showEditModal(id) {
        try {
            const data = await fetchData(`/alumni/${id}`);
            const fields = [
                ['editNama', data.nama],
                ['editTahunMasuk', data.tahun_masuk ? parseInt(data.tahun_masuk) : ''],
                ['editTahunLulus', data.tahun_lulus ? parseInt(data.tahun_lulus) : ''],
                ['editNoTelepon', data.no_telepon],
                ['editEmail', data.email],
                ['editAlamatRumah', data.alamat_rumah],
                ['editIpk', data.ipk ? parseFloat(data.ipk).toFixed(2) : ''],
                ['editLinkedIn', data.linkedin],
                ['editInstagram', data.instagram],
                ['editEmailAlternatif', data.email_alternatif],
                ['editId', data.id]
            ];

            fields.forEach(([fieldId, value]) => document.getElementById(fieldId).value = value ?? '');
            document.getElementById('editForm').action = `/alumni/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengambil data.');
        }
    }

    // Function to delete alumni data
    function deleteDetail(id) {
        const confirmModal = document.getElementById('confirmModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

        // Tampilkan modal konfirmasi
        confirmModal.classList.remove('hidden');

        // Fungsi penghapusan setelah konfirmasi
        confirmDeleteBtn.onclick = () => {
            confirmModal.classList.add('hidden'); // Sembunyikan modal

            fetch(`/alumni/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(response => response.ok ? response.json() : Promise.reject())
            .then(() => {
                alert('Data berhasil dihapus');
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus data.');
            });
        };

        // Membatalkan penghapusan
        cancelDeleteBtn.onclick = () => {
            confirmModal.classList.add('hidden'); // Sembunyikan modal
        };
    }
</script>

