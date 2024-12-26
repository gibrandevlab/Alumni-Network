<div id="editModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 backdrop-blur-sm shadow">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-4xl mx-auto">
        <h3 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Edit Data Event</h3>
        <form id="editForm" action="{{ route('dashboard.events.update', ['event' => ':id']) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" id="editEventId" name="event_id">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="judul_event" class="block text-white dark:text-gray-300">Judul Event</label>
                    <input type="text" id="judul_event" name="judul_event" required maxlength="255"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan Judul Event">
                    @error('judul_event')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi_event" class="block text-white dark:text-gray-300">Deskripsi Event</label>
                    <textarea id="deskripsi_event" name="deskripsi_event" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan Deskripsi Event"></textarea>
                    @error('deskripsi_event')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_mulai" class="block text-white dark:text-gray-300">Tanggal Mulai</label>
                    <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Contoh: 2021-11-11 00:00:00">
                    @error('tanggal_mulai')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_akhir" class="block text-white dark:text-gray-300">Tanggal Akhir</label>
                    <input type="datetime-local" id="tanggal_akhir" name="tanggal_akhir" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Contoh: 2021-11-11 00:00:00">
                    @error('tanggal_akhir')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="dilaksanakan_oleh" class="block text-white dark:text-gray-300">Dilaksanakan Oleh</label>
                    <input type="text" id="dilaksanakan_oleh" name="dilaksanakan_oleh" required maxlength="255"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan Nama Penyelenggara">
                    @error('dilaksanakan_oleh')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tipe_event" class="block text-white dark:text-gray-300">Tipe Event</label>
                    <select id="tipe_event" name="tipe_event" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                        <option value="" disabled selected>Pilih Tipe Event</option>
                        <option value="loker">Loker</option>
                        <option value="event">Event</option>
                    </select>
                    @error('tipe_event')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="foto" class="block text-white dark:text-gray-300">Foto</label>
                    <input type="file" id="foto" name="foto" accept="image/*" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                    @error('foto')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="link" class="block text-white dark:text-gray-300">Link</label>
                    <select id="link_type" name="link_type" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                        <option value="custom" selected>Custom</option>
                        <option value="/dashboard/event/mendaftar">Mendaftar</option>
                    </select>
                    <input type="text" id="link" name="link"
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan Link Event"
                        {{ old('link_type') == 'custom' ? '' : 'style=display:none' }}>
                    @error('link')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <script>
                    const linkTypeSelect = document.getElementById('link_type');
                    const linkInput = document.getElementById('link');

                    function handleLinkTypeChange() {
                        if (linkTypeSelect.value === 'custom') {
                            linkInput.style.display = 'block';
                            linkInput.value = '';
                            linkInput.placeholder = "Masukkan Link Event";
                        } else {
                            linkInput.style.display = 'none';
                            linkInput.value = '/dashboard/event/mendaftar';
                        }
                    }

                    linkTypeSelect.addEventListener('change', handleLinkTypeChange);

                    handleLinkTypeChange();
                </script>


                @push('scripts')
                    <script>
                        const selectLinkType = document.getElementById('link_type');
                        const inputLink = document.getElementById('link');

                        selectLinkType.addEventListener('change', function() {
                            if (this.value == 'custom') {
                                inputLink.removeAttribute('disabled');
                            } else {
                                inputLink.setAttribute('disabled', '');
                            }
                        });
                    </script>
                @endpush
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-800">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function showEditModal(itemId) {
    const editModal = document.getElementById('editModal');
    if (!editModal) {
        console.error('Edit modal tidak ditemukan!');
        return;
    }
    editModal.classList.remove('hidden');

    document.getElementById('editEventId').value = itemId;
    const actionUrl = document.getElementById('editForm').action.replace(':id', itemId);
    document.getElementById('editForm').action = actionUrl;
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) {
        console.error('Modal tidak ditemukan!');
        return;
    }
    modal.classList.add('hidden');
}
</script>
