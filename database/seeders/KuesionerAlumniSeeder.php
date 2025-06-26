<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuesioner;
use App\Models\PertanyaanKuesioner;
use App\Models\ResponKuesioner;

class KuesionerAlumniSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat kuesioner untuk alumni yang bekerja
        $bekerja = Kuesioner::create([
            'judul' => 'Tracer Study Alumni - Bekerja',
            'deskripsi' => 'Kuesioner untuk alumni yang bekerja setelah lulus',
            'tahun_mulai' => 2025,
            'tahun_akhir' => 2025,
            'status' => 'aktif',
        ]);

        // Tambahkan pertanyaan kuesioner "Bekerja"
        $pertanyaanBekerja = [
            ['pertanyaan' => 'Di bidang apa Anda bekerja?', 'tipe' => 'esai', 'skala' => null],
            ['pertanyaan' => 'Seberapa relevan pendidikan di kampus dengan pekerjaan Anda?', 'tipe' => 'likert', 'skala' => '1-5'],
            ['pertanyaan' => 'Apakah pekerjaan Anda sesuai dengan jurusan Anda?', 'tipe' => 'likert', 'skala' => '1-5'],
            ['pertanyaan' => 'Berapa lama waktu yang dibutuhkan untuk mendapatkan pekerjaan pertama?', 'tipe' => 'esai', 'skala' => null],
            ['pertanyaan' => 'Apakah Anda puas dengan pekerjaan Anda saat ini?', 'tipe' => 'likert', 'skala' => '1-5'],
            ['pertanyaan' => 'Berapa penghasilan rata-rata Anda per bulan?', 'tipe' => 'esai', 'skala' => null],
            ['pertanyaan' => 'Apakah pekerjaan ini sesuai dengan ekspektasi Anda?', 'tipe' => 'likert', 'skala' => '1-5'],
            ['pertanyaan' => 'Seberapa sulit Anda mendapatkan pekerjaan ini?', 'tipe' => 'likert', 'skala' => '1-5'],
            ['pertanyaan' => 'Apakah Anda bekerja di dalam atau luar negeri?', 'tipe' => 'pilihan', 'skala' => 'Dalam negeri,Luar negeri'],
            ['pertanyaan' => 'Adakah keterampilan baru yang Anda pelajari di pekerjaan ini?', 'tipe' => 'esai', 'skala' => null],
        ];

        foreach ($pertanyaanBekerja as $i => $p) {
            PertanyaanKuesioner::create([
                'kuesioner_id' => $bekerja->id,
                'pertanyaan' => $p['pertanyaan'],
                'tipe' => $p['tipe'],
                'skala' => $p['skala'],
                'urutan' => $i + 1,
            ]);
        }

        // Membuat respons kuesioner untuk "Bekerja" dengan user_id 2-101
        for ($userId = 2; $userId <= 101; $userId++) {
            $jawaban = [
                'Di bidang apa Anda bekerja?' => 'Teknologi Informasi',
                'Seberapa relevan pendidikan di kampus dengan pekerjaan Anda?' => rand(3, 5),
                'Apakah pekerjaan Anda sesuai dengan jurusan Anda?' => rand(3, 5),
                'Berapa lama waktu yang dibutuhkan untuk mendapatkan pekerjaan pertama?' => '6 bulan',
                'Apakah Anda puas dengan pekerjaan Anda saat ini?' => rand(4, 5),
                'Berapa penghasilan rata-rata Anda per bulan?' => 'Rp10.000.000',
                'Apakah pekerjaan ini sesuai dengan ekspektasi Anda?' => rand(3, 5),
                'Seberapa sulit Anda mendapatkan pekerjaan ini?' => rand(2, 4),
                'Apakah Anda bekerja di dalam atau luar negeri?' => rand(0, 1) ? 'Dalam negeri' : 'Luar negeri',
                'Adakah keterampilan baru yang Anda pelajari di pekerjaan ini?' => 'Manajemen waktu',
            ];

            ResponKuesioner::create([
                'kuesioner_id' => $bekerja->id,
                'user_id' => $userId,
                'jawaban' => json_encode($jawaban),
            ]);
        }

        $this->command->info('Seeder kuesioner alumni dan respons untuk user_id 2-101 berhasil dijalankan!');
    }
}
