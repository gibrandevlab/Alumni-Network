<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Kuesioner Tracer Study</title>
  @vite('resources/css/app.css')
  <script>
    let currentStep = 0,
        responseStatus = "";

    // Fungsi menampilkan langkah (step) sesuai indeks
    function showStep(step) {
      document.querySelectorAll('.step').forEach((s, i) => {
        s.classList.toggle('hidden', i !== step);
      });
    }

    // Fungsi navigasi ke langkah selanjutnya
    function nextStep() {
      const steps = document.querySelectorAll('.step');
      if (currentStep < steps.length - 1) {
        currentStep++;
        // Panggil fungsi setDynamicQuestions() ketika masuk ke Langkah 2 (index = 1)
        if(currentStep === 1) {
          setDynamicQuestions();
        }
        showStep(currentStep);
      }
    }

    // Fungsi navigasi ke langkah sebelumnya
    function previousStep() {
      if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
      }
    }

    // Fungsi untuk menampilkan pertanyaan dinamis sesuai status
    function setDynamicQuestions() {
      // Sembunyikan seluruh opsi dinamis dan nonaktifkan input-nya
      document.querySelectorAll('.dynamic-option').forEach(el => {
        el.classList.add('hidden');
        el.querySelectorAll("input, select, textarea").forEach(input => {
          input.setAttribute("disabled", "disabled");
        });
      });

      // Ambil nilai status yang dipilih (1: Bekerja/Wirausaha, 2: Melanjutkan Pendidikan, 3: Tidak Bekerja)
      const status = document.querySelector('input[name="status"]:checked');
      if (status) {
        responseStatus = status.value;
      }
      // Pemetaan ID div dinamis berdasarkan pilihan status
      const targetDiv = document.getElementById({
        "1": "dynamic-working",
        "2": "dynamic-education",
        "3": "dynamic-not-working"
      }[responseStatus] || "dynamic-not-working");

      targetDiv.classList.remove("hidden");
      targetDiv.querySelectorAll("input, select, textarea").forEach(input => {
        input.removeAttribute("disabled");
      });
    }

    // Set up event listener ketika DOM telah dimuat
    document.addEventListener("DOMContentLoaded", () => {
      showStep(currentStep);
      document.querySelectorAll('input[name="status"]').forEach(radio => {
        radio.addEventListener('change', (e) => responseStatus = e.target.value);
      });

      // Setup tombol pencarian data berdasarkan NIM
      const searchButton = document.getElementById('searchButton');
      const nimInput = document.getElementById('nim');

      if (!searchButton || !nimInput) {
        console.error('Elemen tombol atau input NIM tidak ditemukan.');
        return;
      }

      searchButton.onclick = async () => {
        const nim = nimInput.value.trim();
        if (!nim) {
          alert('Silakan masukkan NIM terlebih dahulu.');
          return;
        }

        try {
          const data = await fetchData(`/search-by-nim/${nim}`);
          if (!data || !data.nama) {
            alert('NIM tidak ditemukan.');
            return;
          }
          // Update field data
          document.getElementById('nama').value = data.nama || '';
          document.getElementById('tahun_lulus').value = data.tahun_lulus || '';
          document.getElementById('jurusan').value = data.jurusan || '';
        } catch (error) {
          console.error('Error:', error);
          alert('Gagal mengambil data. Silakan coba lagi.');
        }
      };
    });

    // Fungsi fetchData untuk mengambil data via API
    async function fetchData(url) {
      try {
        const response = await fetch(url);
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return await response.json();
      } catch (error) {
        console.error('Fetch Error:', error);
        throw error;
      }
    }
  </script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 flex justify-center min-h-screen my-12">
  <div class="w-full max-w-5xl mx-auto">
    <form action="/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020" method="POST">
      @csrf

      <!-- LANGKAH 1: Data Pribadi & Status Pengguna -->
      <div class="step flex flex-col gap-4">
        <div class="bg-white p-8 rounded-lg shadow-2xl">
          <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Data Pribadi</h2>
          <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block mb-2">
                <span class="text-gray-700">NIM</span>
                <div class="flex items-center">
                  <input type="number" name="nim" id="nim"
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    required>
                  <button type="button" id="searchButton"
                    class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Cari
                  </button>
                </div>
              </label>
            </div>
            <div class="w-full md:w-1/2 px-3">
              <label class="block mb-2">
                <span class="text-gray-600">Nama</span>
                <input type="text" name="nama" id="nama"
                  class="block w-full px-4 py-2 mt-2 text-gray-600 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                  required readonly>
              </label>
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block mb-2">
                <span class="text-gray-600">Tahun Lulus</span>
                <input type="number" name="tahun_lulus" id="tahun_lulus"
                  class="block w-full px-4 py-2 mt-2 text-gray-600 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                  required readonly>
              </label>
            </div>
            <div class="w-full md:w-1/2 px-3">
              <label class="block mb-2">
                <span class="text-gray-600">Jurusan</span>
                <input type="text" name="jurusan" id="jurusan"
                  class="block w-full px-4 py-2 mt-2 text-gray-600 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                  required readonly>
              </label>
            </div>
          </div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-2xl mt-6">
          <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Formulir Pengguna</h2>
          <p class="mb-4 text-gray-700">Apa status Anda saat ini?</p>
          <div class="flex flex-col gap-4">
            <label><input type="radio" name="status" value="1" required> Bekerja / Berwirausaha</label>
            <label><input type="radio" name="status" value="2" required> Melanjutkan Pendidikan</label>
            <label><input type="radio" name="status" value="3" required> Tidak Bekerja</label>
          </div>
        </div>

        <div class="flex justify-between items-center mt-6">
          <a href="/pengisian-tracer-study/Tracer-Study-1" type="button" onclick="previousStep()"
                  class="bg-gray-300 px-4 py-2 rounded-lg text-gray-600">Kembali</a>
          <button type="button" onclick="nextStep()"
                  class="bg-purple-500 px-4 py-2 rounded-lg text-white">Berikutnya</button>
        </div>
      </div>

      <!-- LANGKAH 2: Pertanyaan Khusus (Dinamis) -->
      <div class="step bg-white p-8 rounded-lg shadow-2xl hidden">
        <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Pertanyaan Khusus</h2>

        <!-- Bagian untuk Alumni Bekerja / Berwirausaha -->
        <div id="dynamic-working" class="dynamic-option hidden flex flex-col gap-6">
          <!-- Pertanyaan 1 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">1</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apakah Anda telah mendapatkan pekerjaan/berwirausaha ≤ 6 bulan sebelum lulus?
              </label>
              <div class="flex gap-4">
                <label><input type="radio" name="kerja_awal" value="ya" required> Ya</label>
                <label><input type="radio" name="kerja_awal" value="tidak" required> Tidak</label>
              </div>
            </div>
          </div>
          <!-- Pertanyaan 2 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">2</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Dalam berapa bulan Anda mendapatkan pekerjaan/berwirausaha setelah lulus? (isi 0 jika sebelum lulus)
              </label>
              <input type="number" name="durasi_kerja" placeholder="Contoh: 3"
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
          </div>
          <!-- Pertanyaan 3 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">3</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apa nama perusahaan/instansi tempat Anda bekerja/berwirausaha saat ini?
              </label>
              <input type="text" name="nama_perusahaan" placeholder="Contoh: PT. XYZ Indonesia"
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
          </div>
          <!-- Pertanyaan 4 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">4</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apa posisi atau jabatan Anda saat ini?
              </label>
              <input type="text" name="jabatan" placeholder="Contoh: Manajer, Staff, dll."
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
          </div>
          <!-- Pertanyaan 5 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">5</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Di bidang atau industri apa Anda berkecimpung saat ini?
              </label>
              <input type="text" name="bidang_industri" placeholder="Contoh: Teknologi, Keuangan, dll."
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
          </div>
          <!-- Pertanyaan 6 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">6</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Berapa rata-rata pendapatan Anda per bulan? (tanpa titik)
              </label>
              <input type="number" name="pendapatan_bulanan" placeholder="Contoh: 5000000"
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
          </div>
          <!-- Pertanyaan 7 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">7</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Seberapa erat hubungan antara bidang studi dengan pekerjaan/berwirausaha Anda?
              </label>
              <select name="hubungan_studi_pekerjaan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="sangat_erat">Sangat Erat</option>
                <option value="erat">Erat</option>
                <option value="cukup_erat">Cukup Erat</option>
                <option value="kurang_erat">Kurang Erat</option>
                <option value="tidak_sama_sekali">Tidak Sama Sekali</option>
              </select>
            </div>
          </div>
          <!-- Pertanyaan 8 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">8</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Sejauh mana materi perkuliahan dan keterampilan yang diajarkan mendukung pekerjaan/berwirausaha Anda? (Skala 1-5)
              </label>
              <select name="relevansi_pendidikan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="1">1 - Sangat Tidak Relevan</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5 - Sangat Relevan</option>
              </select>
            </div>
          </div>
          <!-- Pertanyaan 9 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">9</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apakah Anda pernah mendapatkan dukungan dari institusi (layanan karier, pelatihan, atau jaringan alumni) yang membantu pengembangan karier atau usaha Anda? Jelaskan.
              </label>
              <textarea name="dukungan_institusi" rows="3" placeholder="Tuliskan pengalaman Anda..."
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
          </div>
          <!-- Pertanyaan 10 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">10</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apa saran atau masukan yang dapat Anda berikan untuk meningkatkan relevansi kurikulum dan layanan institusi?
              </label>
              <textarea name="saran_perbaikan_kerja" rows="3" placeholder="Saran dan masukan..."
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
          </div>
        </div>

        <!-- Bagian untuk Alumni Melanjutkan Pendidikan -->
        <div id="dynamic-education" class="dynamic-option hidden flex flex-col gap-6">
          <!-- Pertanyaan 1 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">1</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Nama institusi dan program studi yang sedang Anda jalani:
              </label>
              <input type="text" name="institusi_pendidikan" placeholder="Contoh: Universitas ABC, Program Studi XYZ"
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>
          </div>
          <!-- Pertanyaan 2 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">2</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Jenjang pendidikan yang ditempuh:
              </label>
              <select name="jenjang_pendidikan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="S2">Magister (S2)</option>
                <option value="S3">Doktor (S3)</option>
                <option value="lainnya">Lainnya</option>
              </select>
            </div>
          </div>
          <!-- Pertanyaan 3 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">3</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apa motivasi utama Anda untuk melanjutkan pendidikan?
              </label>
              <textarea name="motivasi_pendidikan" rows="3" placeholder="Tuliskan motivasi Anda..."
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required></textarea>
            </div>
          </div>
          <!-- Pertanyaan 4 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">4</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Menurut Anda, sejauh mana pendidikan yang telah Anda terima mempersiapkan Anda untuk studi lanjutan? (Skala 1-5)
              </label>
              <select name="persiapan_studi" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="1">1 - Tidak Memadai</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5 - Sangat Memadai</option>
              </select>
            </div>
          </div>
          <!-- Pertanyaan 5 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">5</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apakah ada materi atau keterampilan yang menurut Anda kurang dikuasai saat perkuliahan dan berpengaruh pada studi lanjutan? Jelaskan.
              </label>
              <textarea name="kekurangan_pendidikan" rows="3" placeholder="Tuliskan pendapat Anda..."
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
          </div>
          <!-- Pertanyaan 6 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">6</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apakah institusi menyediakan layanan atau fasilitas (bimbingan akademik, informasi beasiswa) yang membantu kelanjutan studi Anda?
              </label>
              <textarea name="dukungan_pendidikan" rows="3" placeholder="Tuliskan pengalaman atau saran..."
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
          </div>
          <!-- Pertanyaan 7 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">7</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apa saran atau masukan yang dapat membantu institusi meningkatkan kurikulum untuk mendukung kesiapan studi lanjutan?
              </label>
              <textarea name="saran_perbaikan_pendidikan" rows="3" placeholder="Saran dan masukan..."
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
          </div>
        </div>

        <!-- Bagian untuk Alumni yang Belum Bekerja / Tidak Bekerja -->
        <div id="dynamic-not-working" class="dynamic-option hidden flex flex-col gap-6">
          <!-- Pertanyaan 1 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">1</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Mohon jelaskan status Anda saat ini:
              </label>
              <select name="status_tidak_bekerja" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                <option value="mencari_pekerjaan">Sedang mencari pekerjaan</option>
                <option value="pelatihan">Mengikuti pelatihan atau kursus</option>
                <option value="mempertimbangkan">Sedang mempertimbangkan opsi karier</option>
                <option value="lainnya">Lainnya</option>
              </select>
            </div>
          </div>
          <!-- Pertanyaan 2 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">2</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apa faktor utama yang menyebabkan Anda belum bekerja?
              </label>
              <textarea name="alasan_tidak_bekerja" rows="3" placeholder="Tuliskan alasan Anda..."
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required></textarea>
            </div>
          </div>
          <!-- Pertanyaan 3 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">3</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apakah Anda merasa pendidikan yang Anda terima sudah memadai untuk memasuki dunia kerja?
              </label>
              <div class="flex gap-4">
                <label><input type="radio" name="pendidikan_memadai" value="ya" required> Ya</label>
                <label><input type="radio" name="pendidikan_memadai" value="tidak" required> Tidak</label>
              </div>
            </div>
          </div>
          <!-- Pertanyaan 4 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">4</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Adakah materi atau pelatihan yang menurut Anda perlu ditambahkan untuk meningkatkan kesiapan kerja?
              </label>
              <textarea name="saran_pelatihan" rows="3" placeholder="Tuliskan saran Anda..."
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
          </div>
          <!-- Pertanyaan 5 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">5</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apakah Anda pernah mendapatkan bimbingan atau dukungan dari institusi (layanan karier, pelatihan kerja) untuk membantu pencarian kerja?
              </label>
              <div class="flex gap-4">
                <label><input type="radio" name="dukungan_tidak_bekerja" value="ya" required> Ya</label>
                <label><input type="radio" name="dukungan_tidak_bekerja" value="tidak" required> Tidak</label>
              </div>
            </div>
          </div>
          <!-- Pertanyaan 6 -->
          <div class="flex gap-3 items-start">
            <span class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">6</span>
            <div class="flex flex-col gap-4">
              <label class="text-gray-700">
                Apa saran atau masukan yang dapat Anda berikan agar institusi lebih mendukung alumni dalam memasuki dunia kerja?
              </label>
              <textarea name="saran_perbaikan_tidak_bekerja" rows="3" placeholder="Saran dan masukan..."
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            </div>
          </div>
        </div>

        <div class="flex justify-between items-center mt-6">
          <button type="button" onclick="previousStep()"
                  class="bg-gray-300 px-4 py-2 rounded-lg text-gray-600">Sebelumnya</button>
          <button type="button" onclick="nextStep()"
                  class="bg-purple-500 px-4 py-2 rounded-lg text-white">Berikutnya</button>
        </div>
      </div>

      <!-- LANGKAH 3: Pertanyaan Umum & Informasi Kontak Terbaru -->
      <div class="step bg-white p-8 rounded-lg shadow-2xl hidden">
        <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Pertanyaan Umum</h2>
        <!-- Peringatan untuk menjawab dengan jujur -->
        <p class="mb-4 text-red-600 font-semibold">
          PERINGATAN: Mohon jawab pertanyaan berikut dengan jujur sesuai keadaan sebenarnya.
        </p>
        <!-- Pertanyaan Evaluasi -->
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
          <textarea name="aspek_pendidikan" rows="3" placeholder="Tuliskan pendapat Anda..."
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required></textarea>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">
            3. Apakah ada saran, komentar, atau masukan lain untuk meningkatkan kualitas pendidikan dan layanan alumni di institusi ini?
          </label>
          <textarea name="saran_umum" rows="3" placeholder="Saran dan masukan..."
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
        </div>
        <!-- Informasi Kontak Terbaru -->
        <div class="mb-4">
          <label class="block text-gray-700">
            4. Mohon masukkan nomor kontak terbaru (email, telepon, atau lainnya) yang dapat kami hubungi:
          </label>
          <input type="text" name="kontak_terbaru" placeholder="Contoh: email@example.com atau 08123456789"
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400" required>
        </div>
        <div class="flex justify-between items-center mt-6">
          <button type="button" onclick="previousStep()"
                  class="bg-gray-300 px-4 py-2 rounded-lg text-gray-600">Sebelumnya</button>
          <button type="submit" class="bg-purple-500 px-4 py-2 rounded-lg text-white">Kirim</button>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
