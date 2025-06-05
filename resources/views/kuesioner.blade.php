@php
    use Illuminate\Support\Facades\Session;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Event Kuesioner</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Manajemen Event Kuesioner</h1>

        {{-- Flash Message --}}
        @if(Session::has('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ Session::get('error') }}</div>
        @endif

        {{-- Tombol Tambah Event --}}
        <button id="btnTambahEvent" class="mb-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah Event Kuesioner Baru</button>

        {{-- Daftar Event (akan diisi via JS/AJAX) --}}
        <div id="eventList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card event akan di-render di sini -->
        </div>
    </div>

    <!-- Modal Tambah Event -->
    <div id="modalTambahEvent" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <h2 class="text-xl font-semibold mb-4">Tambah Event Kuesioner</h2>
            <form id="formTambahEvent" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Judul Event <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_event" class="w-full border rounded px-3 py-2" required>
                    <div class="text-red-500 text-sm mt-1" data-error="judul_event"></div>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Deskripsi Event <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi_event" class="w-full border rounded px-3 py-2" required></textarea>
                    <div class="text-red-500 text-sm mt-1" data-error="deskripsi_event"></div>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Foto (opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full border rounded px-3 py-2" id="inputFotoEvent">
                    <img id="previewFotoEvent" src="#" alt="Preview" class="mt-2 max-h-32 hidden">
                    <div class="text-red-500 text-sm mt-1" data-error="foto"></div>
                </div>
                <div class="mb-3 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block mb-1 font-medium">Tahun Mulai <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_mulai" class="w-full border rounded px-3 py-2" required>
                        <div class="text-red-500 text-sm mt-1" data-error="tahun_mulai"></div>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Tahun Akhir <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_akhir" class="w-full border rounded px-3 py-2" required>
                        <div class="text-red-500 text-sm mt-1" data-error="tahun_akhir"></div>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Tahun Lulusan <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_lulusan" class="w-full border rounded px-3 py-2" required>
                        <div class="text-red-500 text-sm mt-1" data-error="tahun_lulusan"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Target Peserta</label>
                    <input type="text" name="target_peserta" class="w-full border rounded px-3 py-2">
                    <div class="text-red-500 text-sm mt-1" data-error="target_peserta"></div>
                </div>
                <hr class="my-4">
                <h3 class="font-semibold mb-2">Pertanyaan Wajib (Kategori Umum)</h3>
                <input type="hidden" name="kategori_umum" value="umum">
                <input type="hidden" name="urutan_umum" value="1">
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Tipe</label>
                    <select name="tipe_umum" class="w-full border rounded px-3 py-2" required>
                        <option value="text">Text</option>
                        <option value="radio">Radio</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="rating">Rating</option>
                    </select>
                    <div class="text-red-500 text-sm mt-1" data-error="tipe_umum"></div>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Pertanyaan <span class="text-red-500">*</span></label>
                    <input type="text" name="pertanyaan_umum" class="w-full border rounded px-3 py-2" required>
                    <div class="text-red-500 text-sm mt-1" data-error="pertanyaan_umum"></div>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Skala (untuk radio/checkbox/rating)</label>
                    <div id="skalaUmumContainer" class="space-y-2"></div>
                    <button type="button" id="btnTambahSkalaUmum" class="mt-2 px-2 py-1 bg-gray-200 rounded text-sm">Tambah Pilihan Skala</button>
                    <input type="hidden" name="skala_umum" id="inputSkalaUmum">
                </div>
                <div class="flex justify-end mt-6">
                    <button type="button" id="btnBatalTambahEvent" class="mr-3 px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Modal Tambah Event
    const btnTambahEvent = document.getElementById('btnTambahEvent');
    const modalTambahEvent = document.getElementById('modalTambahEvent');
    const btnBatalTambahEvent = document.getElementById('btnBatalTambahEvent');
    btnTambahEvent.onclick = () => { modalTambahEvent.classList.remove('hidden'); };
    btnBatalTambahEvent.onclick = () => { modalTambahEvent.classList.add('hidden'); resetTambahEventForm(); };

    // Preview Foto
    document.getElementById('inputFotoEvent').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('previewFotoEvent');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                preview.src = ev.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
        }
    });

    // Skala Dinamis Pertanyaan Umum
    const skalaUmumContainer = document.getElementById('skalaUmumContainer');
    const btnTambahSkalaUmum = document.getElementById('btnTambahSkalaUmum');
    let skalaUmumCount = 0;
    btnTambahSkalaUmum.onclick = function() {
        skalaUmumCount++;
        const div = document.createElement('div');
        div.className = 'flex gap-2 items-center';
        div.innerHTML = `<input type='text' class='border rounded px-2 py-1 flex-1' placeholder='Pilihan skala'> <button type='button' class='text-red-500 remove-skala'>Hapus</button>`;
        skalaUmumContainer.appendChild(div);
        div.querySelector('.remove-skala').onclick = function() { div.remove(); updateInputSkalaUmum(); };
        updateInputSkalaUmum();
    };
    function updateInputSkalaUmum() {
        const arr = Array.from(skalaUmumContainer.querySelectorAll('input')).map(i => i.value).filter(Boolean);
        document.getElementById('inputSkalaUmum').value = JSON.stringify(arr);
    }
    skalaUmumContainer.addEventListener('input', updateInputSkalaUmum);

    // Submit Form Tambah Event (AJAX)
    document.getElementById('formTambahEvent').onsubmit = async function(e) {
        e.preventDefault();
        // Reset error
        this.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
        const formData = new FormData(this);
        // Skala umum
        try {
            const skalaArr = JSON.parse(document.getElementById('inputSkalaUmum').value);
            formData.set('skala_umum', JSON.stringify(skalaArr));
        } catch {}
        // AJAX POST
        try {
            const res = await axios.post('/kuesioner', formData, {headers: {'Content-Type': 'multipart/form-data'}});
            if (res.data.success) {
                modalTambahEvent.classList.add('hidden');
                resetTambahEventForm();
                await loadEventList();
            } else {
                alert('Gagal menyimpan event.');
            }
        } catch(err) {
            if (err.response && err.response.data && err.response.data.errors) {
                const errors = err.response.data.errors;
                Object.keys(errors).forEach(k => {
                    const el = document.querySelector(`[data-error="${k}"]`);
                    if (el) el.textContent = errors[k][0];
                });
            } else {
                alert('Terjadi kesalahan.');
            }
        }
    };
    function resetTambahEventForm() {
        document.getElementById('formTambahEvent').reset();
        document.getElementById('previewFotoEvent').classList.add('hidden');
        skalaUmumContainer.innerHTML = '';
        document.getElementById('inputSkalaUmum').value = '[]';
    }

    // Render List Event (AJAX)
    async function loadEventList() {
        const eventList = document.getElementById('eventList');
        eventList.innerHTML = '<div class="col-span-full text-center text-gray-500">Memuat data...</div>';
        try {
            const res = await axios.get('/kuesioner?ajax=1');
            const events = res.data.events || [];
            if (!events.length) {
                eventList.innerHTML = '<div class="col-span-full text-center text-gray-500">Belum ada event.</div>';
                return;
            }
            eventList.innerHTML = '';
            events.forEach(event => {
                eventList.innerHTML += `
                <div class='bg-white rounded-lg shadow p-4 flex flex-col'>
                    <div class='flex-1'>
                        <h3 class='font-bold text-lg mb-1'>${event.judul_event}</h3>
                        <div class='text-gray-600 text-sm mb-2 line-clamp-3'>${event.deskripsi_event}</div>
                        <div class='text-xs text-gray-500 mb-2'>Tahun: ${event.tahun_mulai} - ${event.tahun_akhir} | Lulusan: ${event.tahun_lulusan}</div>
                        <img src="${event.foto_url || '/images/defaultkuesioner.png'}" class="w-full h-32 object-cover rounded mb-2" onerror="this.src='/images/defaultkuesioner.png'">
                    </div>
                    <div class='flex gap-2 mt-2'>
                        <button class='px-3 py-1 bg-yellow-500 text-white rounded edit-event-btn' data-id='${event.id}'>Edit</button>
                        <button class='px-3 py-1 bg-red-500 text-white rounded hapus-event-btn' data-id='${event.id}'>Hapus</button>
                        <a href='/kuesioner/${event.id}/pertanyaan' class='px-3 py-1 bg-blue-600 text-white rounded'>Kelola Pertanyaan</a>
                    </div>
                </div>`;
            });
            // Attach event listeners (edit/hapus)
            document.querySelectorAll('.hapus-event-btn').forEach(btn => {
                btn.onclick = async function() {
                    if (confirm('Yakin hapus event ini beserta seluruh pertanyaan?')) {
                        try {
                            await axios.delete(`/kuesioner/${btn.dataset.id}`);
                            await loadEventList();
                        } catch {
                            alert('Gagal menghapus event.');
                        }
                    }
                };
            });
            // TODO: Edit event modal (bisa ditambahkan sesuai kebutuhan)
        } catch {
            eventList.innerHTML = '<div class="col-span-full text-center text-red-500">Gagal memuat data event.</div>';
        }
    }
    // Inisialisasi awal
    document.addEventListener('DOMContentLoaded', loadEventList);
    </script>
</body>
</html>
