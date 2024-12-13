<form action="">
    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">1. Kapan Anda mulai mencari pekerjaan?</label>
        <select class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none" required>
            <option value="" disabled selected>Pilih opsi</option>
            <option value="sebelum_lulus">Sebelum Lulus</option>
            <option value="setelah_lulus">Setelah Lulus</option>
            <option value="tidak_mencari_kerja">Tidak Mencari Kerja</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">2. Kapan Anda mendapatkan pekerjaan pertama sejak mencari pekerjaan?</label>
        <select class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none" required>
            <option value="" disabled selected>Pilih opsi</option>
            <option value="1-3_bulan">Setelah 1-3 bulan</option>
            <option value="3-6_bulan">Setelah 3-6 bulan</option>
            <option value="6-9_bulan">Setelah 6-9 bulan</option>
            <option value="9-12_bulan">Setelah 9-12 bulan</option>
            <option value="lebih_12_bulan">Lebih dari 12 bulan</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">3. Bagaimana cara Anda mencari pekerjaan?</label>
        <div class="flex flex-col">
            <label class="inline-flex items-center">
                <input type="radio" name="cari_pekerjaan" value="iklan_koran" class="form-radio h-5 w-5 text-indigo-600" required />
                <span class="ml-2 text-black">Melalui iklan koran/majalah dan sejenisnya</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="cari_pekerjaan" value="melamar_perusahaan" class="form-radio h-5 w-5 text-indigo-600" />
                <span class="ml-2 text-black">Melamar ke perusahaan tanpa tahu ada lowongan</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="cari_pekerjaan" value="bursa_kerja" class="form-radio h-5 w-5 text-indigo-600" />
                <span class="ml-2 text-black">Ke bursa kerja</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="cari_pekerjaan" value="internet" class="form-radio h-5 w-5 text-indigo-600" />
                <span class="ml-2 text-black">Internet</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="cari_pekerjaan" value="teman_keluarga" class="form-radio h-5 w-5 text-indigo-600" />
                <span class="ml-2 text-black">Teman / Keluarga</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="cari_pekerjaan" value="lainnya" class="form-radio h-5 w-5 text-indigo-600" />
                <span class="ml-2 text-black">Lainnya</span>
            </label>
        </div>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">4. Jumlah Perusahaan/Instansi/Institusi yang dikirimi surat lamaran kerja sebelum memperoleh pekerjaan pertama:</label>
        <select class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none">
            <option value="" disabled selected>Pilih opsi</option>
            <option value="1-5">1-5</option>
            <option value="6-10">6-10</option>
            <option value="10-15">10-15</option>
            <option value="15-20">15-20</option>
            <option value="20+">20+</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">5. Jumlah Perusahaan/Instansi/Institusi yang merespon surat lamaran dari Anda:</label>
        <select class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none">
            <option value="" disabled selected>Pilih opsi</option>
            <option value="1-10">1-10</option>
            <option value="11-20">11-20</option>
            <option value="20+">20+</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">6. Jumlah Perusahaan/Instansi/Institusi yang mengundang untuk wawancara:</label>
        <input type="number" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none" placeholder="Masukkan angka" required>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">7. Saat Anda mengisi kuesioner ini, apakah Anda sedang bekerja?</label>
        <div class="flex flex-col">
            <label class="inline-flex items-center">
                <input type="radio" name="sedang_bekerja" value="ya" class="form-radio h-5 w-5 text-indigo-600" required />
                <span class="ml-2 text-black">Ya</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="sedang_bekerja" value="tidak" class="form-radio h-5 w-5 text-indigo-600" />
                <span class="ml-2 text-black">Tidak</span>
            </label>
        </div>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">8. Apakah dalam 1 bulan terakhir Anda sedang mencari pekerjaan?</label>
        <select class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none">
            <option value="" disabled selected>Pilih opsi</option>
            <option value="tidak">Tidak</option>
            <option value="tidak_tapi_menunggu_hasil">Tidak, tapi saya sedang menunggu hasil lamaran kerja</option>
            <option value="ya_2_minggu">Ya, saya akan mulai bekerja dalam 2 minggu ke depan</option>
            <option value="ya_tapi_belum_pasti">Ya, tapi saya belum pasti akan bekerja dalam 2 minggu ke depan</option>
            <option value="lainnya">Lainnya</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">9. Perusahaan terakhir tempat Anda bekerja pertama kali setelah lulus:</label>
        <select class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none">
            <option value="" disabled selected>Pilih opsi</option>
            <option value="instansi_pemerintah">Instansi pemerintah (termasuk BUMN)</option>
            <option value="organisasi_non_profit">Organisasi non-profit/lembaga swadaya masyarakat</option>
            <option value="perusahaan_swasta">Perusahaan swasta</option>
            <option value="wiraswasta">Wiraswasta/perusahaan sendiri</option>
            <option value="lainnya">Lainnya</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">10. Bidang Usaha Pekerjaan Alumni:</label>
        <input type="text" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none" placeholder="Masukkan bidang usaha" required>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">11. Frekuensi Pendapatan Alumni:</label>
        <select class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none" required>
            <option value="" disabled selected>Pilih opsi</option>
            <option value="<1_juta">&lt; 1 juta</option>
            <option value="1-3_juta">1-3 juta</option>
            <option value="3-5_juta">3-5 juta</option>
            <option value="5-10_juta">5-10 juta</option>
            <option value="10-20_juta">10-20 juta</option>
            <option value="20+_juta">20+ juta</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">12. Apakah pekerjaan Anda saat ini relevan dengan keahlian yang didapat selama kuliah?</label>
        <div class="flex flex-col">
            <label class="inline-flex items-center">
                <input type="radio" name="relevansi_pekerjaan" value="sangat_relevan" class="form-radio h-5 w-5 text-indigo-600" required />
                <span class="ml-2 text-black">Sangat Relevan</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="relevansi_pekerjaan" value="relevan" class="form-radio h-5 w-5 text-indigo-600" />
                <span class="ml-2 text-black">Relevan</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="relevansi_pekerjaan" value="tidak_relevan" class="form-radio h-5 w-5 text-indigo-600" />
                <span class="ml-2 text-black">Tidak Relevan</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="relevansi_pekerjaan" value="sangat_tidak_relevan" class="form-radio h-5 w-5 text-indigo-600" />
                <span class="ml-2 text-black">Sangat Tidak Relevan</span>
            </label>
        </div>
    </div>

    <div class="mb-6">
        <label class="flex items-center mb-2 text-black text-sm font-medium">13. Kritik dan saran Anda terhadap kurikulum dan pengajaran selama kuliah:</label>
        <textarea class="block w-full h-24 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-black border border-gray-300 rounded placeholder-gray-400 focus:outline-none" placeholder="Masukkan kritik dan saran"></textarea>
    </div>

    <button class="w-52 h-12 bg-indigo-600 hover:bg-indigo-800 transition-all duration-700 rounded-full shadow-xs text-white text-base font-semibold leading-6 mb-6">Kirim</button>
</form>
