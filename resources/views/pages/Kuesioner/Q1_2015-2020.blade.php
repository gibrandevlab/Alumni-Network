<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kuesioner</title>
    @vite('resources/css/app.css')
    <script>
        let currentStep = 0,
            responseStatus = "";

        function showStep(step) {
            document.querySelectorAll('.step').forEach((s, i) => {
                s.classList.toggle('hidden', i !== step);
            });
        }

        function nextStep() {
            const steps = document.querySelectorAll('.step');
            if (currentStep < steps.length - 1) {
                currentStep++;
                setDynamicQuestions();
                showStep(currentStep);
            }
        }

        function previousStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        function setDynamicQuestions() {
            document.querySelectorAll('.dynamic-option').forEach(el => {
                el.classList.add('hidden');
                el.querySelectorAll("input, select, textarea").forEach(input => {
                    input.setAttribute("disabled", "disabled");
                });
            });

            const targetDiv = document.getElementById({
                "1": "dynamic-input-working-1",
                "2": "dynamic-textarea-education",
                "3": "dynamic-checkbox-not-working"
            } [responseStatus] || "dynamic-checkbox-not-working");

            targetDiv.classList.remove("hidden");
            targetDiv.querySelectorAll("input, select, textarea").forEach(input => {
                input.removeAttribute("disabled");
            });
        }

        function toggleOtherInput() {
            const otherInput = document.getElementById('other-company-name');
            otherInput.classList.toggle('hidden', this.value !== 'other');
            if (this.value === 'other') {
                otherInput.setAttribute('required', 'required');
            } else {
                otherInput.removeAttribute('required');
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            showStep(currentStep);
            document.querySelectorAll('input[name="status"]').forEach(radio => {
                radio.addEventListener('change', (e) => responseStatus = e.target.value);
            });
            document.getElementById('company-type').addEventListener('change', toggleOtherInput);
        });

        // Pastikan fetchData adalah fungsi async yang menerima URL dan mengembalikan data
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

        // Ambil elemen tombol dan tambahkan event listener
        document.addEventListener('DOMContentLoaded', () => {
            const searchButton = document.getElementById('searchButton');
            const nimInput = document.getElementById('nim');

            // Pastikan elemen ditemukan
            if (!searchButton || !nimInput) {
                console.error('Elemen tombol atau input NIM tidak ditemukan.');
                return;
            }

            // Tambahkan event handler
            searchButton.onclick = async () => {
                const nim = nimInput.value.trim();

                // Validasi input NIM
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
    </script>


</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 flex justify-center min-h-screen my-12">
    <div class="w-full max-w-5xl"> <!-- Lebar card diubah menjadi max-w-3xl -->
        <form action="/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020" method="POST">
            @csrf
            <!-- Langkah 1 -->
            <div class="step flex flex-col gap-4">
                <div class="bg-white p-8 rounded-lg shadow-2xl">
                    <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Data Pribadi</h2>
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block mb-2">
                                <span class="text-gray-700">NIM</span>
                                <div class="flex items-center">
                                    <!-- Input Field untuk NIM -->
                                    <input type="number" name="nim" id="nim"
                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                        required>
                                    <!-- Tombol Cari -->
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


                <div class="bg-white p-8 rounded-lg shadow-2xl">
                    <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Formulir Pengguna</h2>
                    <p class="mb-4 text-gray-700">Apa status Anda saat ini?</p>
                    <div class="flex flex-col gap-4">
                        <label><input type="radio" name="status" value="1" required> Bekerja / Wirausaha</label>
                        <label><input type="radio" name="status" value="2" required> Melanjutkan
                            Pendidikan</label>
                        <label><input type="radio" name="status" value="3" required> Tidak Bekerja</label>
                    </div>
                    <div class="flex justify-between items-center mt-6">
                        <button type="button" onclick="previousStep()"
                            class="bg-gray-300 px-4 py-2 rounded-lg text-gray-600">Sebelumnya</button>
                        <button type="button" onclick="nextStep()"
                            class="bg-purple-500 px-4 py-2 rounded-lg text-white">Berikutnya</button>
                    </div>
                </div>
            </div>

            <!-- Langkah 2 (Dinamis) -->
            <div class="step bg-white p-8 rounded-lg shadow-2xl hidden">
                <h2 class="text-xl font-semibold text-purple-700 mb-4 text-center">Formulir Pengguna</h2>

                <!-- Input teks untuk Bekerja/Wirausaha -->
                <div id="dynamic-input-working-1" class="dynamic-option hidden flex flex-col gap-6">
                    <!-- Pertanyaan 1 -->
                    <div class="flex gap-3 items-start">
                        <span
                            class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">1</span>
                        <div class="flex flex-col gap-4">
                            <label class="text-gray-700">
                                Apakah Anda telah mendapatkan pekerjaan/berwiraswasta <= 6 bulan sebelum lulus? </label>
                                    <div class="flex gap-4 container">
                                        <label>
                                            <input type="radio" name="status_kerja" value="ya" required> Ya
                                        </label>
                                        <label>
                                            <input type="radio" name="status_kerja" value="tidak"> Tidak
                                        </label>
                                    </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 2 -->
                    <div class="flex gap-3 items-start">
                        <span
                            class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">2</span>
                        <div class="flex flex-col gap-4 container">
                            <label class="text-gray-700">
                                Dalam berapa bulan Anda mendapatkan pekerjaan/berwiraswasta setelah lulus? (isi 0 jika
                                sebelum lulus)
                            </label>
                            <input type="number" name="durasi_kerja" placeholder="Contoh: 3"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"
                                required>
                        </div>
                    </div>

                    <!-- Pertanyaan 3 -->
                    <div class="flex gap-3 items-start">
                        <span
                            class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">3</span>
                        <div class="flex flex-col gap-4 container">
                            <label class="text-gray-700">
                                Apa nama perusahaan/kantor tempat Anda bekerja/berwiraswasta saat ini?
                            </label>
                            <input type="text" name="nama_perusahaan" placeholder="Contoh: PT. XYZ Indonesia"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"
                                required>
                        </div>
                    </div>

                    <!-- Pertanyaan 4 -->
                    <div class="flex gap-3 items-start">
                        <span
                            class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">4</span>
                        <div class="flex flex-col gap-4 container">
                            <label class="text-gray-700">
                                Berapa rata-rata pendapatan Anda per bulan? (Tanpa titik)
                            </label>
                            <input type="number" name="pendapatan_bulanan" placeholder="Contoh: 5000000"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"
                                required>
                        </div>
                    </div>

                    <!-- Pertanyaan 5 -->
                    <div class="flex gap-3 items-start">
                        <span
                            class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">5</span>
                        <div class="flex flex-col gap-4 container">
                            <label class="text-gray-700">
                                Seberapa erat hubungan antara bidang studi dengan pekerjaan Anda?
                            </label>
                            <select name="hubungan_studi_pekerjaan"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"
                                required>
                                <option value="sangat_erat">Sangat Erat</option>
                                <option value="erat">Erat</option>
                                <option value="cukup_erat">Cukup Erat</option>
                                <option value="kurang_erat">Kurang Erat</option>
                                <option value="tidak_sama_sekali">Tidak Sama Sekali</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pertanyaan 6 -->
                    <div class="flex gap-3 items-start">
                        <span
                            class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">6</span>
                        <div class="flex flex-col gap-4 container">
                            <label class="text-gray-700">
                                Apakah pekerjaan Anda saat ini memerlukan tingkat pendidikan sesuai bidang studi Anda?
                            </label>
                            <div class="flex gap-4">
                                <label>
                                    <input type="radio" name="syarat_pendidikan" value="ya" required> Ya
                                </label>
                                <label>
                                    <input type="radio" name="syarat_pendidikan" value="tidak"> Tidak
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan 7 -->
                    <div class="flex gap-3 items-start">
                        <span
                            class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">7</span>
                        <div class="flex flex-col gap-4 container">
                            <label class="text-gray-700">
                                Apa jenis perusahaan/instansi tempat Anda bekerja sekarang?
                            </label>
                            <select name="jenis_perusahaan" id="jenis_perusahaan"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"
                                required>
                                <option value="pemerintah">Instansi Pemerintah</option>
                                <option value="bumn">BUMN/BUMD</option>
                                <option value="multilateral">Organisasi Multilateral</option>
                                <option value="non_profit">Organisasi Non-Profit</option>
                                <option value="swasta">Perusahaan Swasta</option>
                                <option value="wiraswasta">Wiraswasta</option>

                            </select>
                        </div>
                    </div>
                </div>

                <!-- Textarea untuk Melanjutkan Pendidikan -->
                <div id="dynamic-textarea-education" class="dynamic-option hidden">
                    <label class="text-gray-700">Jurusan atau program studi yang sedang ditempuh:</label>
                    <textarea name="info_tambahan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"
                        rows="3"></textarea>
                </div>

                <!-- Checkbox untuk Tidak Bekerja -->
                <div id="dynamic-checkbox-not-working" class="dynamic-option hidden">
                    <div class="flex gap-3 items-start">
                        <span
                            class="text-white bg-purple-400 rounded-full w-8 h-8 flex items-center justify-center">5</span>
                        <div class="flex flex-col gap-4 container w-full">
                            <label for="alasan" class="text-gray-700">
                                Alasan tidak bekerja:
                            </label>
                            <select name="alasan" id="alasan-5"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400"
                                required>
                                <option value="menikah">Menikah</option>
                                <option value="keluarga">Mengurus Keluarga</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
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
