@extends('layouts.Dashboard.dashboard')

@section('content')
<div class="min-h-screen flex flex-row flex-auto flex-shrink-0 antialiased dark:bg-gray-300 text-black dark:text-white">
    @include('layouts.Dashboard.sidebarkiri')
@endsection
    @php
        // Kompatibilitas variabel lama
        $alumniProfiles = $alumni ?? null;
    @endphp
    <div class="h-full mx-14 my-14 md:mx-64" style="padding-left: 1rem; padding-right: 1rem;">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manage Alumni</h1>
        </header>
        <section>
            @include('components.dashboard.Member Setting.table-member')
        </section>
    </div>
</div>


<style>
    @media (max-width: 768px) {
        .min-h-screen {
            padding: 1rem;
        }
        header h1 {
            font-size: 1.5rem;
        }
    }
</style>

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

