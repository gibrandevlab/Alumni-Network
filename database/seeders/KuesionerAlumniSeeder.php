<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuesioner;
use App\Models\PertanyaanKuesioner;

class KuesionerAlumniSeeder extends Seeder
{
    public function run(): void
    {
        // Kuesioner untuk alumni yang bekerja
        $bekerja = Kuesioner::create([
            'judul' => 'Tracer Study Alumni - Bekerja',
            'deskripsi' => 'Kuesioner untuk alumni yang bekerja setelah lulus',
            'tahun_mulai' => 2025,
            'tahun_akhir' => 2025,
            'status' => 'aktif',
        ]);

        $pertanyaanBekerja = [
            // Tambahkan minimal 15 pertanyaan terkait bekerja
            [
                'pertanyaan' => 'Di bidang apa Anda bekerja?',
                'tipe' => 'esai',
                'skala' => null,
            ],
            [
                'pertanyaan' => 'Seberapa relevan pendidikan di kampus dengan pekerjaan Anda?',
                'tipe' => 'likert',
                'skala' => '1-5',
            ],
            // Tambahkan 13 pertanyaan lainnya
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

        // Kuesioner untuk alumni yang melanjutkan pendidikan
        $pendidikan = Kuesioner::create([
            'judul' => 'Tracer Study Alumni - Melanjutkan Pendidikan',
            'deskripsi' => 'Kuesioner untuk alumni yang melanjutkan pendidikan setelah lulus',
            'tahun_mulai' => 2025,
            'tahun_akhir' => 2025,
            'status' => 'aktif',
        ]);

        $pertanyaanPendidikan = [
            // Tambahkan minimal 15 pertanyaan terkait pendidikan
            [
                'pertanyaan' => 'Jenjang pendidikan yang Anda ambil saat ini?',
                'tipe' => 'pilihan',
                'skala' => 'S2,S3,Doktor,Lainnya',
            ],
            [
                'pertanyaan' => 'Apakah pendidikan lanjutan ini sesuai dengan minat Anda sebelumnya?',
                'tipe' => 'likert',
                'skala' => '1-5',
            ],
            // Tambahkan 13 pertanyaan lainnya
        ];

        foreach ($pertanyaanPendidikan as $i => $p) {
            PertanyaanKuesioner::create([
                'kuesioner_id' => $pendidikan->id,
                'pertanyaan' => $p['pertanyaan'],
                'tipe' => $p['tipe'],
                'skala' => $p['skala'],
                'urutan' => $i + 1,
            ]);
        }

        // Kuesioner untuk alumni dengan aktivitas lainnya
        $lainnya = Kuesioner::create([
            'judul' => 'Tracer Study Alumni - Aktivitas Lainnya',
            'deskripsi' => 'Kuesioner untuk alumni dengan aktivitas lain setelah lulus',
            'tahun_mulai' => 2025,
            'tahun_akhir' => 2025,
            'status' => 'aktif',
        ]);

        $pertanyaanLainnya = [
            // Tambahkan pertanyaan terkait aktivitas lainnya
            [
                'pertanyaan' => 'Sebutkan aktivitas utama Anda saat ini.',
                'tipe' => 'esai',
                'skala' => null,
            ],
            [
                'pertanyaan' => 'Apakah Anda merasa puas dengan aktivitas ini?',
                'tipe' => 'likert',
                'skala' => '1-5',
            ],
            // Tambahkan pertanyaan tambahan lainnya
        ];

        foreach ($pertanyaanLainnya as $i => $p) {
            PertanyaanKuesioner::create([
                'kuesioner_id' => $lainnya->id,
                'pertanyaan' => $p['pertanyaan'],
                'tipe' => $p['tipe'],
                'skala' => $p['skala'],
                'urutan' => $i + 1,
            ]);
        }

        $this->command->info('Seeder kuesioner alumni berhasil dijalankan!');
    }
}
