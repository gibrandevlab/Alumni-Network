<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formulir Tracer Study Alumni</title>
  @vite('resources/css/app.css')
  <script>
    let currentStep = 0,
        responseStatus = "";

    // Menampilkan langkah (step) sesuai indeks
    function showStep(step) {
      document.querySelectorAll('.step').forEach((s, i) => {
        s.classList.toggle('hidden', i !== step);
      });
      // Jika berada di langkah pertanyaan dinamis (step 1), tampilkan pertanyaan sesuai status
      if (step === 1) {
        setDynamicQuestions();
      }
    }

    function nextStep() {
      const steps = document.querySelectorAll('.step');
      if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
      }
    }

    function previousStep() {
      if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
      }
    }

    // Menampilkan pertanyaan dinamis sesuai status alumni
    function setDynamicQuestions() {
      // Sembunyikan seluruh bagian dinamis terlebih dahulu dan nonaktifkan input-nya
      document.querySelectorAll('.dynamic-option').forEach(el => {
        el.classList.add('hidden');
        el.querySelectorAll("input, select, textarea").forEach(input => {
          input.setAttribute("disabled", "disabled");
        });
      });
      // Ambil status yang dipilih pada step 0
      const status = document.querySelector('input[name="status"]:checked');
      if (status) {
        responseStatus = status.value;
      }
      // Pemetaan: 1 = Bekerja / Berwirausaha, 2 = Melanjutkan Pendidikan, 3 = Belum Bekerja
      const targetDivId = {
        "1": "dynamic-working",
        "2": "dynamic-education",
        "3": "dynamic-not-working"
      }[responseStatus] || "dynamic-not-working";

      const targetDiv = document.getElementById(targetDivId);
      if (targetDiv) {
        targetDiv.classList.remove("hidden");
        targetDiv.querySelectorAll("input, select, textarea").forEach(input => {
          input.removeAttribute("disabled");
        });
      }
    }

    document.addEventListener("DOMContentLoaded", () => {
      showStep(currentStep);
      document.querySelectorAll('input[name="status"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
          responseStatus = e.target.value;
        });
      });
      // Menampilkan atau menyembunyikan informasi kontak terbaru berdasarkan pilihan kontak lanjutan (jika diperlukan)
      document.querySelectorAll('input[name="kontak_lanjutan"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
          document.getElementById('kontak-info').style.display = (e.target.value === 'ya') ? 'block' : 'none';
        });
      });
    });
  </script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 flex justify-center min-h-screen my-12">
  <div class="w-full max-w-5xl mx-auto">
    <form action="/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020" method="POST">
      @csrf

      <!-- STEP 0: Status Saat Ini -->
      <div class="step flex flex-col gap-4">
        <div class="bg-white p-8 rounded-lg shadow-2xl">
          <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Status Saat Ini</h2>
          <p class="mb-4 text-gray-700">Saat ini, kegiatan utama Anda adalah:</p>
          <div class="flex flex-col gap-4">
            <label>
              <input type="radio" name="status" value="1" required> Bekerja / Berwirausaha
            </label>
            <label>
              <input type="radio" name="status" value="2" required> Melanjutkan Pendidikan
            </label>
            <label>
              <input type="radio" name="status" value="3" required> Belum Bekerja / Tidak Bekerja
            </label>
          </div>
        </div>
        <div class="flex justify-end items-center mt-6">
          <button type="button" onclick="nextStep()" class="bg-purple-500 px-4 py-2 rounded-lg text-white">Berikutnya</button>
        </div>
      </div>

      <!-- STEP 1: Pertanyaan Khusus (Dinamis) -->
      <div class="step hidden flex flex-col gap-4">
        <div class="bg-white p-8 rounded-lg shadow-2xl">
          <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Pertanyaan Khusus</h2>

          <!-- Bagian untuk Alumni Bekerja / Berwirausaha -->
          <div id="dynamic-working" class="dynamic-option hidden">
            <h3 class="text-lg font-semibold mb-4">Bekerja / Berwirausaha</h3>
            <div class="mb-4">
              <label class="block text-gray-700">
                1. Apakah Anda telah mendapatkan pekerjaan/berwirausaha ≤ 6 bulan sebelum lulus?
              </label>
              <div class="mt-2">
                <label><input type="radio" name="kerja_awal" value="ya" required> Ya</label>
                <label class="ml-4"><input type="radio" name="kerja_awal" value="tidak" required> Tidak</label>
              </div>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                2. Dalam berapa bulan Anda mendapatkan pekerjaan/berwirausaha setelah lulus? (isi 0 jika sebelum lulus)
              </label>
              <input type="number" name="durasi_kerja" placeholder="Contoh: 3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                3. Apa nama perusahaan/instansi tempat Anda bekerja/berwirausaha saat ini?
              </label>
              <input type="text" name="nama_perusahaan" placeholder="Contoh: PT. XYZ Indonesia" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                4. Apa posisi atau jabatan Anda saat ini?
              </label>
              <input type="text" name="jabatan" placeholder="Contoh: Manajer, Staff, dll." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                5. Di bidang atau industri apa Anda berkecimpung saat ini?
              </label>
              <input type="text" name="bidang_industri" placeholder="Contoh: Teknologi, Keuangan, dll." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                6. Berapa rata-rata pendapatan Anda per bulan? (tanpa titik)
              </label>
              <input type="number" name="pendapatan_bulanan" placeholder="Contoh: 5000000" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                7. Seberapa erat hubungan antara bidang studi dengan pekerjaan/berwirausaha Anda?
              </label>
              <select name="hubungan_studi_pekerjaan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="sangat_erat">Sangat Erat</option>
                <option value="erat">Erat</option>
                <option value="cukup_erat">Cukup Erat</option>
                <option value="kurang_erat">Kurang Erat</option>
                <option value="tidak_sama_sekali">Tidak Sama Sekali</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                8. Sejauh mana materi perkuliahan dan keterampilan yang diajarkan mendukung pekerjaan/berwirausaha Anda? (Skala 1-5)
              </label>
              <select name="relevansi_pendidikan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="1">1 - Sangat Tidak Relevan</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5 - Sangat Relevan</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                9. Apakah Anda pernah mendapatkan dukungan dari institusi (layanan karier, pelatihan, atau jaringan alumni) yang membantu pengembangan karier atau usaha Anda? Jelaskan.
              </label>
              <textarea name="dukungan_institusi" rows="3" placeholder="Tuliskan pengalaman Anda..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                10. Apa saran atau masukan yang dapat Anda berikan untuk meningkatkan relevansi kurikulum dan layanan institusi?
              </label>
              <textarea name="saran_perbaikan_kerja" rows="3" placeholder="Saran dan masukan..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required></textarea>
            </div>
          </div>

          <!-- Bagian untuk Alumni Melanjutkan Pendidikan -->
          <div id="dynamic-education" class="dynamic-option hidden">
            <h3 class="text-lg font-semibold mb-4">Melanjutkan Pendidikan</h3>
            <div class="mb-4">
              <label class="block text-gray-700">
                1. Nama institusi dan program studi yang sedang Anda jalani:
              </label>
              <input type="text" name="institusi_pendidikan" placeholder="Contoh: Universitas ABC, Program Studi XYZ" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                2. Jenjang pendidikan yang ditempuh:
              </label>
              <select name="jenjang_pendidikan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
                <option value="lainnya">Lainnya</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                3. Apa motivasi utama Anda untuk melanjutkan pendidikan?
              </label>
              <textarea name="motivasi_pendidikan" rows="3" placeholder="Tuliskan motivasi Anda..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                4. Menurut Anda, sejauh mana pendidikan yang telah Anda terima mempersiapkan Anda untuk studi lanjutan? (Skala 1-5)
              </label>
              <select name="persiapan_studi" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="1">1 - Tidak Memadai</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5 - Sangat Memadai</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                5. Apakah ada materi atau keterampilan yang menurut Anda kurang dikuasai saat perkuliahan dan berpengaruh pada studi lanjutan? Jelaskan.
              </label>
              <textarea name="kekurangan_pendidikan" rows="3" placeholder="Tuliskan pendapat Anda..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                6. Apakah institusi menyediakan layanan atau fasilitas (bimbingan akademik, informasi beasiswa) yang membantu kelanjutan studi Anda?
              </label>
              <textarea name="dukungan_pendidikan" rows="3" placeholder="Tuliskan pengalaman atau saran..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                7. Apa saran atau masukan yang dapat membantu institusi meningkatkan kurikulum untuk mendukung kesiapan studi lanjutan?
              </label>
              <textarea name="saran_perbaikan_pendidikan" rows="3" placeholder="Saran dan masukan..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
          </div>

          <!-- Bagian untuk Alumni yang Belum Bekerja / Tidak Bekerja -->
          <div id="dynamic-not-working" class="dynamic-option hidden">
            <h3 class="text-lg font-semibold mb-4">Belum Bekerja / Tidak Bekerja</h3>
            <div class="mb-4">
              <label class="block text-gray-700">
                1. Mohon jelaskan status Anda saat ini:
              </label>
              <select name="status_tidak_bekerja" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="mencari_pekerjaan">Sedang mencari pekerjaan</option>
                <option value="pelatihan">Mengikuti pelatihan atau kursus</option>
                <option value="mempertimbangkan">Sedang mempertimbangkan opsi karier</option>
                <option value="lainnya">Lainnya</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                2. Apa faktor utama yang menyebabkan Anda belum bekerja?
              </label>
              <textarea name="alasan_tidak_bekerja" rows="3" placeholder="Tuliskan alasan Anda..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                3. Apakah Anda merasa pendidikan yang Anda terima sudah memadai untuk memasuki dunia kerja?
              </label>
              <div class="mt-2">
                <label><input type="radio" name="pendidikan_memadai" value="ya" required> Ya</label>
                <label class="ml-4"><input type="radio" name="pendidikan_memadai" value="tidak" required> Tidak</label>
              </div>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                4. Adakah materi atau pelatihan yang menurut Anda perlu ditambahkan untuk meningkatkan kesiapan kerja?
              </label>
              <textarea name="saran_pelatihan" rows="3" placeholder="Tuliskan saran Anda..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                5. Apakah Anda pernah mendapatkan bimbingan atau dukungan dari institusi (layanan karier, pelatihan kerja) untuk membantu pencarian kerja?
              </label>
              <div class="mt-2">
                <label><input type="radio" name="dukungan_tidak_bekerja" value="ya" required> Ya</label>
                <label class="ml-4"><input type="radio" name="dukungan_tidak_bekerja" value="tidak" required> Tidak</label>
              </div>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">
                6. Apa saran atau masukan yang dapat Anda berikan agar institusi lebih mendukung alumni dalam memasuki dunia kerja?
              </label>
              <textarea name="saran_perbaikan_tidak_bekerja" rows="3" placeholder="Saran dan masukan..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
          </div>
        </div>
        <div class="flex justify-between items-center mt-6">
          <button type="button" onclick="previousStep()" class="bg-gray-300 px-4 py-2 rounded-lg text-gray-600">Sebelumnya</button>
          <button type="button" onclick="nextStep()" class="bg-purple-500 px-4 py-2 rounded-lg text-white">Berikutnya</button>
        </div>
      </div>

      <!-- STEP 2: Pertanyaan Umum dan Informasi Kontak Terbaru -->
      <div class="step hidden flex flex-col gap-4">
        <div class="bg-white p-8 rounded-lg shadow-2xl">
          <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Pertanyaan Umum</h2>
          <!-- Peringatan untuk menjawab dengan jujur -->
          <p class="mb-4 text-red-600 font-semibold">PERINGATAN: Mohon jawab pertanyaan berikut dengan jujur sesuai keadaan sebenarnya.</p>

          <div class="mb-4">
            <label class="block text-gray-700">
              1. Secara umum, bagaimana Anda menilai kualitas pendidikan yang telah Anda terima di institusi ini?
            </label>
            <select name="penilaian_pendidikan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
              <option value="1">1 - Sangat Buruk</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5 - Sangat Baik</option>
            </select>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700">
              2. Apa saja aspek yang paling memuaskan dan yang perlu ditingkatkan?
            </label>
            <textarea name="aspek_pendidikan" rows="3" placeholder="Tuliskan pendapat Anda..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700">
              3. Apakah ada saran, komentar, atau masukan lain untuk meningkatkan kualitas pendidikan dan layanan alumni di institusi ini?
            </label>
            <textarea name="saran_umum" rows="3" placeholder="Saran dan masukan..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
          </div>
          <!-- Informasi kontak terbaru -->
          <div class="mb-4">
            <label class="block text-gray-700">
              4. Mohon masukkan nomor kontak terbaru (email, telepon, atau lainnya) yang dapat kami hubungi:
            </label>
            <input type="text" name="kontak_terbaru" placeholder="Contoh: email@example.com atau 08123456789" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
          </div>
        </div>
        <div class="flex justify-between items-center mt-6">
          <button type="button" onclick="previousStep()" class="bg-gray-300 px-4 py-2 rounded-lg text-gray-600">Sebelumnya</button>
          <button type="submit" class="bg-purple-500 px-4 py-2 rounded-lg text-white">Kirim</button>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
