@extends('layouts.Dashboard.dashboard')

@section('title', 'Admin - SITRA BSI')

@section('content')
    @if ($peranPengguna == 'admin')
        <div
            class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-800 text-black dark:text-white">
            @include('layouts.Dashboard.navbaratas')
            @include('layouts.Dashboard.sidebarkiri')

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64 p-6">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    @include('components.dashboard.User Setting.table-user', ['users' => $users])
                </div>
            </div>
        </div>
    @endif

    @include('components.dashboard.User Setting.detail-user')

    {{-- Modal Pop-Up untuk Edit Data --}}
    @include('components.dashboard.User Setting.edit-user')

    {{-- Modal Pop-Up untuk Tambah Data --}}
    @include('components.dashboard.User Setting.create-user')
@endsection

<script>
    const showCreateModal = () => {
        document.getElementById('createModal').classList.remove('hidden');
        document.getElementById('createForm').reset();
    };

    const closeModal = (modalId) => {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        modalId === 'editModal' ? document.getElementById('editForm').reset() : document.getElementById('createForm').reset();
    };

    const fetchData = async (url) => {
        try {
            const response = await fetch(url);
            if (response.ok) {
                return await response.json();
            } else {
                throw new Error('Data tidak ditemukan');
            }
        } catch (error) {
            console.error('Error:', error);
            return null;
        }
    };

    const showDetail = async (id) => {
        try {
            const data = await fetchData(`/dashboard/user/setting/${id}`);
            if (!data) {
                alert('Gagal mengambil data. Silakan coba lagi.');
                return;
            }

            const initialFields = [
                { label: 'Email', value: data.email },
                { label: 'Role', value: data.role },
                { label: 'Status', value: data.status }
            ];

            const userDetail = document.getElementById('userDetail');
            userDetail.innerHTML = initialFields
                .map(field => `
                <tr class="border-b">
                    <td class="py-2 px-4 font-bold text-white">${field.label}:</td>
                    <td class="py-2 px-4 text-white">${field.value ?? '-'}</td>
                </tr>
            `).join('');

            const cekDataBtn = document.createElement('button');
            cekDataBtn.className = 'px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 mt-4';
            cekDataBtn.textContent = 'Cek Data';

            cekDataBtn.onclick = async () => {
                const additionalData = await fetchData(`/alumni/${id}`);
                if (!additionalData) {
                    alert('Gagal mengambil data. Silakan coba lagi.');
                    return;
                }

                const additionalFields = [
                    { label: 'NIM', value: additionalData.nim },
                    { label: 'Nama', value: additionalData.nama },
                    { label: 'Tahun Masuk', value: additionalData.tahun_masuk },
                    { label: 'Tahun Lulus', value: additionalData.tahun_lulus },
                    { label: 'No Telepon', value: additionalData.no_telepon },
                    { label: 'Alamat Rumah', value: additionalData.alamat_rumah },
                    { label: 'IPK', value: additionalData.ipk },
                    { label: 'LinkedIn', value: additionalData.linkedin },
                    { label: 'Instagram', value: additionalData.instagram },
                    { label: 'Email Alternatif', value: additionalData.email_alternatif },
                    { label: 'Created At', value: additionalData.created_at },
                    { label: 'Updated At', value: additionalData.updated_at }
                ];

                userDetail.innerHTML += additionalFields
                    .map(field => `
                    <tr class="border-b">
                        <td class="py-2 px-4 font-bold text-white">${field.label}:</td>
                        <td class="py-2 px-4 text-white">${field.value ?? '-'}</td>
                    </tr>
                `).join('');
                cekDataBtn.remove();
            };

            userDetail.appendChild(cekDataBtn);
            document.getElementById('detailModal').classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengambil data. Silakan coba lagi.');
        }
    };

    const getStatusColor = (status) => ({
        'approved': 'text-green-500',
        'rejected': 'text-red-500',
        'pending': 'text-gray-400'
    }[status] || 'text-gray-500');

    const showEditModal = async (id) => {
    try {
        const data = await fetchData(`/dashboard/user/setting/${id}`);
        if (!data) return;

        const fields = [
            { id: 'editEmail', value: data.email },
            { id: 'editPassword', value: data.password },
            { id: 'editRole', value: data.role },
            { id: 'editStatus', value: data.status },
            { id: 'editId', value: data.id }
        ];

        fields.forEach(({ id, value }) => {
            const input = document.getElementById(id);
            if (input) input.value = value ?? '';
        });

        // Dynamically set the action URL for the form
        document.getElementById('editForm').action = `/dashboard/user/setting/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal mengambil data.');
    }
};


    const deleteDetail = (id) => {
        const confirmModal = document.getElementById('confirmModal');
        confirmModal.classList.remove('hidden');

        document.getElementById('confirmDeleteBtn').onclick = () => {
            confirmModal.classList.add('hidden');
            fetch(`/dashboard/user/setting/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(response => response.ok ? response.json() : Promise.reject('Gagal menghapus data.'))
            .then(() => {
                alert('Data berhasil dihapus');
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus data.');
            });
        };

        document.getElementById('cancelDeleteBtn').onclick = () => confirmModal.classList.add('hidden');
    };
</script>

