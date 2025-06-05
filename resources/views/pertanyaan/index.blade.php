@php
    use Illuminate\Support\Facades\Session;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pertanyaan Kuesioner</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Kelola Pertanyaan Kuesioner</h1>
        <div id="pertanyaanTabs" class="mb-6 flex flex-wrap gap-2 items-center">
            <!-- Tab kategori dinamis -->
        </div>
        <div class="mb-4">
            <button id="btnTambahKategori" class="px-3 py-1 bg-green-600 text-white rounded">Tambah Kategori Baru</button>
        </div>
        <div id="pertanyaanTabContent">
            <!-- Daftar pertanyaan per kategori -->
        </div>
        <div class="mt-8">
            <a href="/kuesioner" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar Event</a>
        </div>
    </div>

    <!-- Modal Tambah/Edit Pertanyaan -->
    <div id="modalPertanyaan" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <h2 id="modalPertanyaanTitle" class="text-xl font-semibold mb-4">Tambah/Edit Pertanyaan</h2>
            <form id="formPertanyaan">
                <input type="hidden" name="pertanyaan_id" id="pertanyaan_id">
                <input type="hidden" name="event_kuesioner_id" id="event_kuesioner_id">
                <input type="hidden" name="kategori" id="kategori">
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Tipe</label>
                    <select name="tipe" id="tipe" class="w-full border rounded px-3 py-2">
                        <option value="text">Text</option>
                        <option value="radio">Radio</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="rating">Rating</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Urutan</label>
                    <input type="number" name="urutan" id="urutan" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Pertanyaan</label>
                    <textarea name="pertanyaan" id="pertanyaan" class="w-full border rounded px-3 py-2" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Skala (untuk radio/checkbox/rating)</label>
                    <div id="skalaContainer" class="space-y-2"></div>
                    <button type="button" id="btnTambahSkala" class="mt-2 px-2 py-1 bg-gray-200 rounded text-sm">Tambah Pilihan Skala</button>
                    <input type="hidden" name="skala" id="inputSkala">
                </div>
                <div class="flex justify-end mt-6">
                    <button type="button" id="btnBatalPertanyaan" class="mr-3 px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Data dari backend (Blade):
    const eventId = {{ $event->id }};
    const kategoriData = @json(array_keys($kategori->toArray()));
    const pertanyaanData = @json($kategori);

    // Tab kategori dinamis
    const pertanyaanTabs = document.getElementById('pertanyaanTabs');
    const pertanyaanTabContent = document.getElementById('pertanyaanTabContent');
    let currentKategori = kategoriData[0] || '';

    function renderTabs() {
        pertanyaanTabs.innerHTML = '';
        kategoriData.forEach(kat => {
            const btn = document.createElement('button');
            btn.className = 'px-4 py-2 rounded ' + (kat === currentKategori ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700');
            btn.textContent = kat;
            btn.onclick = () => { currentKategori = kat; renderTabs(); renderTabContent(); };
            pertanyaanTabs.appendChild(btn);
        });
    }
    function renderTabContent() {
        const list = pertanyaanData[currentKategori] || [];
        let html = '';
        html += `<div class='mb-4 flex justify-between items-center'>
            <span class='font-semibold'>Kategori: ${currentKategori}</span>
            <button class='px-3 py-1 bg-blue-600 text-white rounded' id='btnTambahPertanyaan'>Tambah Pertanyaan</button>
        </div>`;
        if (!list.length) {
            html += `<div class='text-gray-500 text-center'>Belum ada pertanyaan.</div>`;
        } else {
            html += `<div class='space-y-3'>`;
            list.forEach(q => {
                html += `<div class='bg-white rounded shadow p-3 flex flex-col md:flex-row md:items-center md:justify-between'>
                    <div>
                        <div class='font-semibold'>#${q.urutan} - ${q.tipe}</div>
                        <div class='text-gray-700 mb-1'>${q.pertanyaan}</div>
                        <div class='text-xs text-gray-500'>Skala: ${(q.skala||[]).join(', ')}</div>
                    </div>
                    <div class='flex gap-2 mt-2 md:mt-0'>
                        <button class='px-3 py-1 bg-yellow-500 text-white rounded edit-pertanyaan-btn' data-id='${q.id}'>Edit</button>
                        <button class='px-3 py-1 bg-red-500 text-white rounded hapus-pertanyaan-btn' data-id='${q.id}'>Hapus</button>
                    </div>
                </div>`;
            });
            html += `</div>`;
        }
        pertanyaanTabContent.innerHTML = html;
        document.getElementById('btnTambahPertanyaan').onclick = () => openModalPertanyaan('tambah');
        document.querySelectorAll('.edit-pertanyaan-btn').forEach(btn => {
            btn.onclick = () => openModalPertanyaan('edit', btn.dataset.id);
        });
        document.querySelectorAll('.hapus-pertanyaan-btn').forEach(btn => {
            btn.onclick = () => hapusPertanyaan(btn.dataset.id);
        });
    }
    renderTabs();
    renderTabContent();

    // Modal Tambah/Edit Pertanyaan
    const modalPertanyaan = document.getElementById('modalPertanyaan');
    const formPertanyaan = document.getElementById('formPertanyaan');
    const btnBatalPertanyaan = document.getElementById('btnBatalPertanyaan');
    const skalaContainer = document.getElementById('skalaContainer');
    const btnTambahSkala = document.getElementById('btnTambahSkala');
    let modePertanyaan = 'tambah';
    let editId = null;
    // Tombol tambah kategori baru (selain 'umum')
    document.getElementById('btnTambahKategori').onclick = function() {
        let nama = prompt('Masukkan nama kategori baru (selain "umum")');
        if (!nama) return;
        nama = nama.trim().toLowerCase();
        if (!nama || nama === 'umum' || kategoriData.includes(nama)) {
            alert('Kategori tidak valid atau sudah ada!');
            return;
        }
        kategoriData.push(nama);
        pertanyaanData[nama] = [];
        currentKategori = nama;
        renderTabs();
        renderTabContent();
    };
    // Pada openModalPertanyaan, jika kategori bukan 'umum', izinkan user edit nama kategori (input text)
    const kategoriInput = document.getElementById('kategori');
    function openModalPertanyaan(mode, id = null) {
        modePertanyaan = mode;
        editId = id;
        formPertanyaan.reset();
        skalaContainer.innerHTML = '';
        document.getElementById('event_kuesioner_id').value = eventId;
        if(currentKategori === 'umum') {
            kategoriInput.value = 'umum';
            kategoriInput.type = 'hidden';
        } else {
            kategoriInput.type = 'text';
            kategoriInput.value = currentKategori;
            kategoriInput.className = 'w-full border rounded px-3 py-2 mb-3';
            kategoriInput.readOnly = false;
        }
        document.getElementById('modalPertanyaanTitle').textContent = mode === 'tambah' ? 'Tambah Pertanyaan' : 'Edit Pertanyaan';
        if (mode === 'edit' && id) {
            axios.get(`/kuesioner/${eventId}/pertanyaan/${id}/edit`).then(res => {
                const q = res.data;
                document.getElementById('pertanyaan_id').value = q.id;
                document.getElementById('tipe').value = q.tipe;
                document.getElementById('urutan').value = q.urutan;
                document.getElementById('pertanyaan').value = q.pertanyaan;
                kategoriInput.value = q.kategori;
                if(q.kategori === 'umum') kategoriInput.type = 'hidden';
                (q.skala||[]).forEach(val => addSkalaInput(val));
                updateInputSkala();
            });
        }
        modalPertanyaan.classList.remove('hidden');
    }
    btnBatalPertanyaan.onclick = () => { modalPertanyaan.classList.add('hidden'); };
    // Skala dinamis
    function addSkalaInput(val = '') {
        const div = document.createElement('div');
        div.className = 'flex gap-2 items-center';
        div.innerHTML = `<input type='text' class='border rounded px-2 py-1 flex-1' value='${val}' placeholder='Pilihan skala'> <button type='button' class='text-red-500 remove-skala'>Hapus</button>`;
        skalaContainer.appendChild(div);
        div.querySelector('.remove-skala').onclick = function() { div.remove(); updateInputSkala(); };
        updateInputSkala();
    }
    btnTambahSkala.onclick = () => addSkalaInput();
    skalaContainer.addEventListener('input', updateInputSkala);
    function updateInputSkala() {
        const arr = Array.from(skalaContainer.querySelectorAll('input')).map(i => i.value).filter(Boolean);
        document.getElementById('inputSkala').value = JSON.stringify(arr);
    }
    // Submit form pertanyaan (AJAX)
    formPertanyaan.onsubmit = async function(e) {
        e.preventDefault();
        const formData = new FormData(formPertanyaan);
        try {
            formData.set('skala', document.getElementById('inputSkala').value);
            if (modePertanyaan === 'tambah') {
                await axios.post(`/kuesioner/${eventId}/pertanyaan`, formData);
            } else {
                await axios.post(`/kuesioner/${eventId}/pertanyaan/${editId}?_method=PUT`, formData);
            }
            modalPertanyaan.classList.add('hidden');
            await reloadPertanyaan();
        } catch (err) {
            alert('Gagal menyimpan pertanyaan.');
        }
    };
    async function hapusPertanyaan(id) {
        if (!confirm('Yakin hapus pertanyaan ini?')) return;
        try {
            await axios.delete(`/kuesioner/${eventId}/pertanyaan/${id}`);
            await reloadPertanyaan();
        } catch {
            alert('Gagal menghapus pertanyaan.');
        }
    }
    async function reloadPertanyaan() {
        // Ambil ulang data pertanyaan dari backend
        const res = await axios.get(`/kuesioner/${eventId}/pertanyaan`);
        const all = res.data;
        // Re-group by kategori
        const grouped = {};
        all.forEach(q => {
            if (!grouped[q.kategori]) grouped[q.kategori] = [];
            grouped[q.kategori].push(q);
        });
        // Update kategoriData dan pertanyaanData
        kategoriData.length = 0;
        Object.keys(grouped).forEach(k => kategoriData.push(k));
        for (const k in pertanyaanData) delete pertanyaanData[k];
        Object.assign(pertanyaanData, grouped);
        // Render ulang
        if (!kategoriData.includes(currentKategori)) currentKategori = kategoriData[0] || '';
        renderTabs();
        renderTabContent();
    }
    </script>
</body>
</html>
