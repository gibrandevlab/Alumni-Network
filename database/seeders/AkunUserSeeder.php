<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilAlumni;
use App\Models\ProfilAdmin;
use App\Models\ResponKuesioner;
use App\Models\EventPengembanganKarir;
use App\Models\PendaftaranEvent;
use App\Models\PembayaranEvent;
use App\Models\Message;
use App\Models\Kuesioner;
use App\Models\PertanyaanKuesioner;

class AkunUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Users
        $roles = ['admin', 'alumni'];
        $statuses = ['pending', 'approved', 'rejected'];

        foreach ($roles as $role) {
            foreach ($statuses as $status) {
                $user = User::create([
                    'email' => "$role.$status@example.com",
                    'nama' => ucfirst($role) . ' ' . ucfirst($status),
                    'password' => Hash::make('password'),
                    'role' => $role,
                    'status' => $status,
                    'foto' => null,
                ]);

                if ($role === 'admin') {
                    ProfilAdmin::create([
                        'user_id' => $user->id,
                        'no_telepon' => '081234567890',
                        'jabatan' => 'Manager',
                    ]);
                } elseif ($role === 'alumni') {
                    ProfilAlumni::create([
                        'user_id' => $user->id,
                        'nim' => '123456789',
                        'jurusan' => 'Teknik Informatika',
                        'tahun_masuk' => 2015,
                        'tahun_lulus' => 2019,
                        'no_telepon' => '081234567891',
                        'alamat_rumah' => 'Jl. Alumni No. 1',
                        'ipk' => 3.75,
                        'linkedin' => 'https://linkedin.com/in/alumni',
                        'instagram' => 'https://instagram.com/alumni',
                        'email_alternatif' => 'alumni.alt@example.com',
                    ]);
                }
            }
        }

        // Seed EventPengembanganKarir
        $event = EventPengembanganKarir::create([
            'judul_event' => 'Career Fair 2025',
            'deskripsi_event' => 'A career fair for alumni.',
            'tanggal_mulai' => now(),
            'tanggal_akhir_pendaftaran' => now()->addDays(10),
            'dilaksanakan_oleh' => 'BSI University',
            'tipe_event' => 'event',
            'foto' => null,
            'link' => 'https://example.com',
            'harga_daftar' => 50000,
            'maksimal_peserta' => 100,
        ]);


        // Seed Messages
        Message::create([
            'user_id' => User::first()->id,
            'message' => 'Welcome to the Alumni Network!',
            'media_path' => null,
            'media_type' => null,
        ]);

        // Seed EventKuesioner
        Kuesioner::create([
            'judul_event' => 'Tracer Study 2025',
            'deskripsi_event' => 'A study to track alumni progress.',
            'foto' => null,
            'tahun_mulai' => 2020,
            'tahun_akhir' => 2025,
            'tahun_lulusan' => 2019,
            'status' => 'aktif',
        ]);

        // Seed ResponKuesioner
        ResponKuesioner::create([
            'event_kuesioner_id' => Kuesioner::first()->id,
            'jawaban' => json_encode(['question1' => 'answer1', 'question2' => 'answer2']),
            'user_id' => User::where('role', 'alumni')->first()->id,
        ]);

        // Seed PertanyaanKuesioner (46 pertanyaan)
        $eventKuesionerId = Kuesioner::first()->id;
        // Umum
        PertanyaanKuesioner::create([
            'event_kuesioner_id' => $eventKuesionerId,
            'kategori' => 'umum',
            'tipe' => 'pilihan',
            'urutan' => 1,
            'pertanyaan' => 'Saat ini, aktivitas utama Anda adalah?',
            'skala' => json_encode(["Bekerja", "Melanjutkan Pendidikan", "Lainnya"]),
        ]);
        // Bekerja - Likert (P2-P11)
        $bekerjaLikert = [
            'Pendidikan di universitas memberikan pengetahuan teknis yang relevan dengan pekerjaan saya saat ini.',
            'Keterampilan non-teknis (presentasi, kerja tim) dari perkuliahan bermanfaat dalam pekerjaan.',
            'Jaringan alumni/koneksi universitas membantu karir saya.',
            'Kurikulum sesuai dengan tuntutan industri terkini.',
            'Dukungan karier dari universitas (job fair, konseling) efektif.',
            'Praktikum/magang mempersiapkan saya untuk lingkungan kerja.',
            'Saya mampu bersaing di dunia kerja berkat kompetensi dari kampus.',
            'Etika profesional yang diajarkan relevan dengan budaya perusahaan.',
            'Fasilitas penunjang pembelajaran (lab, perpustakaan) memadai.',
            'Pengalaman kuliah berkontribusi signifikan terhadap kesuksesan karir.'
        ];
        foreach ($bekerjaLikert as $i => $q) {
            PertanyaanKuesioner::create([
                'event_kuesioner_id' => $eventKuesionerId,
                'kategori' => 'bekerja',
                'tipe' => 'likert',
                'urutan' => $i+2,
                'pertanyaan' => $q,
                'skala' => json_encode([1,2,3,4,5]),
            ]);
        }
        // Bekerja - Esai (P11-P15)
        $bekerjaEsai = [
            'Deskripsikan satu keterampilan spesifik dari perkuliahan yang paling berguna di pekerjaan.',
            'Aspek apa yang kurang dari pendidikan Anda untuk relevansi dunia kerja?',
            'Ceritakan pengalaman konkret menggunakan jaringan alumni (jika ada).',
            'Saran untuk universitas dalam mempersiapkan mahasiswa menghadapi dunia kerja.',
            'Rencana pengembangan karir 5 tahun ke depan dan peran kampus.'
        ];
        foreach ($bekerjaEsai as $i => $q) {
            PertanyaanKuesioner::create([
                'event_kuesioner_id' => $eventKuesionerId,
                'kategori' => 'bekerja',
                'tipe' => 'esai',
                'urutan' => $i+12,
                'pertanyaan' => $q,
                'skala' => null,
            ]);
        }
        // Pendidikan - Likert (P2-P11)
        $pendidikanLikert = [
            'Pendidikan sebelumnya memberikan fondasi akademik kuat untuk studi lanjut.',
            'Metode penelitian (skripsi/tesis) memadai untuk tuntutan S2/S3.',
            'Bimbingan dosen mempersiapkan saya untuk studi lanjut.',
            'Akses jurnal ilmiah dan perpustakaan mendukung riset.',
            'Lingkungan akademik kampus memotivasi studi lanjut.',
            'Kurikulum mendorong pengembangan pola pikir kritis.',
            'Kolaborasi riset antar fakultas mudah diakses.',
            'Saya mendapat rekomendasi kuat dari dosen untuk pendaftaran.',
            'Fasilitas riset (laboratorium) memenuhi standar.',
            'Pengalaman organisasi mengembangkan soft skill untuk studi lanjut.'
        ];
        $likertSkala = [
            ["label" => "Sangat Tidak Setuju", "value" => 1],
            ["label" => "Tidak Setuju", "value" => 2],
            ["label" => "Netral", "value" => 3],
            ["label" => "Setuju", "value" => 4],
            ["label" => "Sangat Setuju", "value" => 5],
        ];
        foreach ($pendidikanLikert as $i => $q) {
            PertanyaanKuesioner::create([
                'event_kuesioner_id' => $eventKuesionerId,
                'kategori' => 'pendidikan',
                'tipe' => 'likert',
                'urutan' => $i+2,
                'pertanyaan' => $q,
                'skala' => json_encode($likertSkala),
            ]);
        }
        // Pendidikan - Esai (P11-P15)
        $pendidikanEsai = [
            'Deskripsikan topik riset saat ini dan kaitannya dengan bidang sebelumnya.',
            'Kendala terbesar dalam transisi dari S1 ke S2/S3.',
            'Peran dosen pembimbing yang paling berkesan.',
            'Sarana akademik apa yang belum disediakan kampus tetapi krusial?',
            'Harapan untuk kolaborasi riset dengan institusi studi lanjut.'
        ];
        foreach ($pendidikanEsai as $i => $q) {
            PertanyaanKuesioner::create([
                'event_kuesioner_id' => $eventKuesionerId,
                'kategori' => 'pendidikan',
                'tipe' => 'esai',
                'urutan' => $i+12,
                'pertanyaan' => $q,
                'skala' => null,
            ]);
        }
        // Lainnya - Likert (P2-P11)
        $lainnyaLikert = [
            'Fleksibilitas kurikulum memungkinkan eksplorasi minat non-akademik.',
            'Saya mendapat dukungan untuk pengembangan diri (wirausaha/sosial).',
            'Keterampilan hidup (problem solving) berguna dalam aktivitas saat ini.',
            'Universitas memberi ruang untuk membangun identitas diri.',
            'Jaringan alumni bermanfaat untuk aktivitas non-konvensional.',
            'Layanan kampus (inkubator bisnis) mudah diakses.',
            'Sistem perkuliahan mendorong kemandirian menentukan jalur pasca-lulus.',
            'Saya puas dengan pengalaman organisasi ekstrakurikuler.',
            'Dukungan untuk karir alternatif (freelance/seni) memadai.',
            'Pendidikan membantu saya memahami potensi diri secara holistik.'
        ];
        foreach ($lainnyaLikert as $i => $q) {
            PertanyaanKuesioner::create([
                'event_kuesioner_id' => $eventKuesionerId,
                'kategori' => 'lainnya',
                'tipe' => 'likert',
                'urutan' => $i+2,
                'pertanyaan' => $q,
                'skala' => json_encode([1,2,3,4,5]),
            ]);
        }
        // Lainnya - Esai (P11-P15)
        $lainnyaEsai = [
            'Deskripsikan aktivitas utama saat ini dan kaitannya dengan pengalaman kuliah.',
            'Peluang/tantangan terbesar dalam menjalani pilihan ini.',
            'Peran universitas yang diharapkan untuk dukungan jalur non-tradisional.',
            'Keterampilan unik dari perkuliahan yang paling berguna.',
            'Saran untuk membuat kampus lebih inklusif terhadap berbagai tujuan karir.'
        ];
        foreach ($lainnyaEsai as $i => $q) {
            PertanyaanKuesioner::create([
                'event_kuesioner_id' => $eventKuesionerId,
                'kategori' => 'lainnya',
                'tipe' => 'esai',
                'urutan' => $i+12,
                'pertanyaan' => $q,
                'skala' => null,
            ]);
        }
    }
}
