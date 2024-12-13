<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->seedUsers();
        $this->seedProfilAdmin();
        $this->seedProfilAlumni();
        $this->seedEventKuesioner();
        $this->seedResponKuesioner();
    }

    protected function seedUsers()
    {
        DB::table('users')->insert([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'role' => 'admin',
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 1; $i <= 5000; $i++) {
            DB::table('users')->insert([
                'email' => "alumni$i@gmail.com",
                'password' => Hash::make('password123'),
                'role' => 'alumni',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 1; $i <= 30; $i++) {
            DB::table('users')->insert([
                'email' => "pending_alumni$i@gmail.com",
                'password' => Hash::make('password123'),
                'role' => 'alumni',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'email' => "rejected_alumni$i@gmail.com",
                'password' => Hash::make('password123'),
                'role' => 'alumni',
                'status' => 'rejected',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    protected function seedProfilAdmin()
    {
        DB::table('profil_admin')->insert([
            'user_id' => 1,
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'no_telepon' => '08123456789',
            'jabatan' => 'Administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function seedProfilAlumni()
    {
        $namaPertama = [
            'Arunika',
            'Binar',
            'Cahaya',
            'Darana',
            'Elara',
            'Fajar',
            'Gema',
            'Harum',
            'Intan',
            'Jembar',
            'Jiho',
            'Minjun',
            'Seojin',
            'Jisoo',
            'Eunwoo',
            'Yejun',
            'Haeun',
            'Suhyun',
            'Jiwon',
            'Yeonjun',
            'Lina',
            'Irfan',
            'Sari',
            'Tariq',
            'Kirana',
            'Zara',
            'Tomo',
            'Daya',
            'Raka',
            'Luki',
            'Tina',
            'Asha',
            'Lailah',
            'Farhan',
            'Rina',
            'Zein',
            'Aiman',
            'Maya',
            'Taufan',
            'Arya',
            'Rizki',
            'Fahira',
            'Nina',
            'Dian',
            'Nabil',
            'Ayu',
            'Laras',
            'Safira',
            'Aliyah',
            'Bagus',
            'Nia',
            'Rizwan',
            'Mila',
            'Suci',
            'Amara',
            'Benyamin',
            'Cahyo',
            'Dinda',
            'Erwin',
            'Farah',
            'Hanna',
            'Iqbal',
            'Jihan',
            'Khalis',
            'Larasati',
            'Mimi',
            'Naufal',
            'Olivia',
            'Pandu',
            'Rifki',
            'Siska',
            'Tasha',
            'Umar',
            'Vera',
            'Wulan',
            'Xander',
            'Yanti',
            'Zaid',
            'Abigail',
            'Nathalia',
            'Zulkifli',
            'Farisya',
            'Fadil',
            'Rafael',
            'Heni',
            'Celine',
            'Lia',
            'Fatma',
            'Sarah',
            'Titi',
            'Vina',
            'Dicky',
            'Ilham',
            'Anis',
            'Maretha',
            'Celia',
            'Dewi',
            'Abdi',
            'Dicky',
            'Joko',
            'Jumi',
            'Miko',
            'Wira',
            'Arum',
            'Vira',
            'Zera',
            'Renata',
            'Azka',
            'Raihan',
            'Dian',
            'Sandy',
            'Pratiwi',
            'Yusuf',
            'Dea',
            'Shafa',
            'Reva',
            'Johan',
            'Dinda',
            'Fira',
            'Rifqi',
            'Sarah',
            'Abdi',
            'Gita',
            'Hilda',
            'Candra',
            'Syifa',
            'Alya',
            'Melia',
            'Tami',
            'Angga',
            'Ika',
            'Shifa',
            'Imam',
            'Kendra',
            'Reza',
            'Muryati',
            'Saliha',
            'Vivi',
            'Indah',
            'Syafira',
            'Tania',
            'Shakira',
            'Nathasya',
            'Gilang',
            'Hendra',
            'Kamelia',
            'Keisha',
            'Rani',
            'Putu',
            'Febri',
            'Khayra',
            'Yumna',
            'Tanty',
            'Rayhan',
            'Veronica',
            'Ikhwan',
            'Rishan',
            'Farida',
            'Fahmi',
            'Andi',
            'Aliza',
            'Nova',
            'Siska',
            'Ainun',
            'Zahra',
            'Aqiila',
            'Dafina',
            'Violeta',
            'Alifah',
            'Adnan',
            'Nina',
            'Pasha',
            'Mardiana',
            'Sari',
            'Hafiz',
            'Iqbal',
            'Liza',
            'Budi',
            'Haris',
            'Widyawati',
            'Putri'
        ];

        $namaKedua = [
            'Kasih',
            'Lazuardi',
            'Mentari',
            'Nirwana',
            'Oksara',
            'Pelita',
            'Qisma',
            'Rimba',
            'Senja',
            'Tunas',
            'Haneul',
            'Min',
            'Seo',
            'Ji',
            'Hyun',
            'Woo',
            'Yoon',
            'Soo',
            'Ha',
            'Jun',
            'Amira',
            'Bintang',
            'Citra',
            'Rafi',
            'Alya',
            'Rizki',
            'Aldo',
            'Laili',
            'Tari',
            'Rasya',
            'Zul',
            'Nabila',
            'Kamil',
            'Rachma',
            'Fahmi',
            'Dara',
            'Fika',
            'Gita',
            'Mira',
            'Faris',
            'Ika',
            'Rena',
            'Dewi',
            'Vina',
            'Putri',
            'Yudha',
            'Dian',
            'Anisa',
            'Aisha',
            'Imani',
            'Kirana',
            'Sandy',
            'Dianita',
            'Maulida',
            'Khalis',
            'Rizal',
            'Nida',
            'Budi',
            'Fitri',
            'Tina',
            'Suci',
            'Risma',
            'Ratna',
            'Marta',
            'Desta',
            'Wahyu',
            'Vira',
            'Taufik',
            'Rina',
            'Agus',
            'Budi',
            'Amira',
            'Sabila',
            'Aulia',
            'Mufidah',
            'Ranya',
            'Alfian',
            'Bahar',
            'Nana',
            'Anwar',
            'Anita',
            'Widi',
            'Fani',
            'Aldira',
            'Jolanda',
            'Nadia',
            'Eka',
            'Riva',
            'Surya',
            'Fawzan',
            'Indah',
            'Yuni',
            'Hasanah',
            'Helena',
            'Diah',
            'Iwan',
            'Sidiq',
            'Sari',
            'Rasyid',
            'Qatarina',
            'Rizwan',
            'Syafiq',
            'Vera',
            'Ryana',
            'Zaira',
            'Deva',
            'Ayesha',
            'Lina',
            'Kardinal',
            'Kharisma',
            'Alfian',
            'Hendra',
            'Dian',
            'Atsar',
            'Frida',
            'Marlina',
            'Tara',
            'Ricky',
            'Maya',
            'Rizwan',
            'Anwar',
            'Sulaiman',
            'Abdul',
            'Rahman',
            'Erni',
            'Ismail',
            'Wahyu',
            'Titi',
            'Miki',
            'Rina',
            'Furqan',
            'Beny',
            'Siska',
            'Maya',
            'Glen',
            'Ronny',
            'Nadia',
            'Reza',
            'Irma',
            'Marita',
            'Ratih',
            'Elisya',
            'Putu',
            'Ita',
            'Alfie',
            'Viona',
            'Iwan',
            'Kumalasari',
            'Yanti',
            'Arissa',
            'Icha',
            'Dinar',
            'Faisal',
            'Tutu',
            'Melisa',
            'Budi',
            'Ilham',
            'Rizky',
            'Sofa',
            'Sarina',
            'Tahir',
            'Emilia',
            'Linda',
            'Gisela',
            'Wida',
            'Didi',
            'Samsul',
            'Irwan',
            'Aulia',
            'Fendy',
            'Petrus',
            'Rayyan',
            'Hermawan',
            'Agung',
            'Madinah',
            'Ridho',
            'Mayra',
            'Irfan',
            'Tara',
            'Putra',
            'Renata',
            'Dita',
            'Bima',
            'Risna',
            'Alvina',
            'Andri',
            'Cahyo',
            'Vera',
            'Syarif',
            'Arham',
            'Misha',
            'Rizki',
            'Irfan',
            'Bimo',
            'Rohana',
            'Firdaus'
        ];

        $namaKetiga = [
            'Unggul',
            'Veda',
            'Wira',
            'Xyra',
            'Yodha',
            'Zamrud',
            'Cipta',
            'Asa',
            'Aluna',
            'Surya',
            'Jung',
            'Kim',
            'Park',
            'Choi',
            'Kang',
            'Lim',
            'Han',
            'Lee',
            'Shin',
            'Yoo',
            'Zahir',
            'Nashir',
            'Bayu',
            'Fadhil',
            'Hidayat',
            'Iqbal',
            'Dwi',
            'Maya',
            'Darto',
            'Kurniawan',
            'Rajasa',
            'Irfan',
            'Rijal',
            'Haris',
            'Bagus',
            'Angga',
            'Kusuma',
            'Arief',
            'Setyo',
            'Diana',
            'Akbar',
            'Putra',
            'Gilang',
            'Ramadhan',
            'Raka',
            'Fariz',
            'Kadir',
            'Ilham',
            'Ricky',
            'Ardi',
            'Mursid',
            'Dian',
            'Ricky',
            'Riko',
            'Devendra',
            'Feri',
            'Zaenal',
            'Bima',
            'Rifan',
            'Anggoro',
            'Nanda',
            'Rully',
            'Hendi',
            'Yusuf',
            'Mardi',
            'Arif',
            'Kurnia',
            'Lutfi',
            'Bima',
            'Hardi',
            'Dicky',
            'Hasyim',
            'Iqbal',
            'Ramli',
            'Joko',
            'Roni',
            'Azis',
            'Aditya',
            'Farhan',
            'Wendi',
            'Raden',
            'Dani',
            'Yogi',
            'Anwar',
            'Faiz',
            'Yosef',
            'Ari',
            'Salman',
            'Rauf',
            'Alif',
            'Irsan',
            'Hendra',
            'Alamsyah',
            'Gusti',
            'Riswan',
            'Umar',
            'Sigit',
            'Arianto',
            'Rida',
            'Kurnia',
            'Ilham',
            'Oktavian',
            'Adem',
            'Mohammad',
            'Robi',
            'Rayhan',
            'Bahrul',
            'Alfi',
            'Reza',
            'Beng',
            'Aditya',
            'Zain',
            'Haikal',
            'Riza',
            'Ulya',
            'Ali',
            'Basri',
            'Widya',
            'Fayola',
            'Lina',
            'Sodik',
            'Rizwan',
            'Sutrisno',
            'Arif',
            'Indra',
            'Taufik',
            'Hermawan',
            'Riski',
            'Nizar',
            'Gilang',
            'Imam'
        ];

        for ($i = 1; $i <= 5000; $i++) {
            $jumlahKata = rand(3, 5);

            $nama = [];
            if ($jumlahKata >= 1) $nama[] = $namaPertama[array_rand($namaPertama)];
            if ($jumlahKata >= 2) $nama[] = $namaKedua[array_rand($namaKedua)];
            if ($jumlahKata >= 3) $nama[] = $namaKetiga[array_rand($namaKetiga)];
            if ($jumlahKata >= 4) $nama[] = $namaPertama[array_rand($namaPertama)];
            if ($jumlahKata == 5) $nama[] = $namaKedua[array_rand($namaKedua)];

            shuffle($nama);

            $namaGabungan = implode(' ', $nama);

            $tahunLulus = rand(2014, 2024);
            $tahunMasuk = $tahunLulus - rand(3, 4);

            DB::table('profil_alumni')->insert([
                'user_id' => $i + 1,
                'nim' => '192' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'nama' => $namaGabungan,
                'jurusan' => [
                    'Ilmu Komunikasi (S1)',
                    'Sastra Inggris (S1)',
                    'Public Relations (D3)',
                    'Broadcasting (D3)',
                    'Advertising (D3)',
                    'Bahasa Inggris (D3)',
                    'Sistem Informasi (S1)',
                    'Teknologi Informasi (S1)',
                    'Software Engineering (S1)',
                    'Informatika (S1)',
                    'Teknik Industri (S1)',
                    'Teknik Elektro (S1)',
                    'Sistem Informasi (D3)',
                    'Sistem Informasi Akuntansi (D3)',
                    'Teknologi Komputer (D3)',
                    'Manajemen (S1)',
                    'Akuntansi (S1)',
                    'Pariwisata (S1)',
                    'Hukum Bisnis (S1)',
                    'Administrasi Perkantoran (D3)',
                    'Akuntansi (D3)',
                    'Administrasi Bisnis (D3)',
                    'Manajemen Pajak (D3)',
                    'Perhotelan (D3)',
                    'Hukum Bisnis (S1)',
                    'Ilmu Hukum (S1)',
                    'Hukum Internasional (S1)',
                    'Ilmu Keperawatan (S1)',
                    'Psikologi (S1)',
                    'Ilmu Keperawatan (D3)',
                    'Profesi NERS'
                ][array_rand([
                    'Ilmu Komunikasi (S1)',
                    'Sastra Inggris (S1)',
                    'Public Relations (D3)',
                    'Broadcasting (D3)',
                    'Advertising (D3)',
                    'Bahasa Inggris (D3)',
                    'Sistem Informasi (S1)',
                    'Teknologi Informasi (S1)',
                    'Software Engineering (S1)',
                    'Informatika (S1)',
                    'Teknik Industri (S1)',
                    'Teknik Elektro (S1)',
                    'Sistem Informasi (D3)',
                    'Sistem Informasi Akuntansi (D3)',
                    'Teknologi Komputer (D3)',
                    'Manajemen (S1)',
                    'Akuntansi (S1)',
                    'Pariwisata (S1)',
                    'Hukum Bisnis (S1)',
                    'Administrasi Perkantoran (D3)',
                    'Akuntansi (D3)',
                    'Administrasi Bisnis (D3)',
                    'Manajemen Pajak (D3)',
                    'Perhotelan (D3)',
                    'Hukum Bisnis (S1)',
                    'Ilmu Hukum (S1)',
                    'Hukum Internasional (S1)',
                    'Ilmu Keperawatan (S1)',
                    'Psikologi (S1)',
                    'Ilmu Keperawatan (D3)',
                    'Profesi NERS'
                ])],
                'tahun_masuk' => $tahunMasuk,
                'tahun_lulus' => $tahunLulus,
                'no_telepon' => '0812345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'email' => "alumni$i@gmail.com",
                'alamat_rumah' => "Alamat Alumni $i",
                'ipk' => $this->generateIPK(),
                'linkedin' => "https://linkedin.com/in/alumni$i",
                'instagram' => "https://instagram.com/alumni$i",
                'email_alternatif' => "alt_alumni$i@gmail.com",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    protected function generateIPK()
    {
        $integerPart = rand(2, 4);

        if ($integerPart == 4) {
            $decimalPart = 0;
        } else {
            $decimalPart = rand(0, 99);
        }

        return (float) ($integerPart + $decimalPart / 100);
    }

    protected function seedEventKuesioner()
    {
        DB::table('event_kuesioner')->insert([
            'judul_event' => 'Event Kuesioner Pertama',
            'deskripsi_event' => 'Deskripsi untuk event kuesioner pertama.',
            'tanggal_mulai' => now(),
            'tanggal_akhir' => now()->addDays(30),
            'tahun_lulusan' => 2024,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function seedResponKuesioner()
    {
        $eventKuesionerId = DB::table('event_kuesioner')->first()->id;
        $users = DB::table('users')
            ->where('role', 'alumni')
            ->where('status', 'approved')
            ->pluck('id');

        // Ambil sebagian responden saja (contoh: 70% dari total approved)
        $jumlahResponden = (int)($users->count() * 0.7);
        $responden = $users->shuffle()->take($jumlahResponden)->values();

        // Tentukan distribusi status
        $jumlahStatus1 = (int)(0.5 * $jumlahResponden); // 50% bekerja
        $jumlahStatus2 = (int)(0.3 * $jumlahResponden); // 30% melanjutkan pendidikan
        $jumlahStatus3 = $jumlahResponden - $jumlahStatus1 - $jumlahStatus2; // sisanya tidak bekerja

        $statusDistribusi = array_merge(
            array_fill(0, $jumlahStatus1, 1),
            array_fill(0, $jumlahStatus2, 2),
            array_fill(0, $jumlahStatus3, 3)
        );
        shuffle($statusDistribusi); // Acak distribusi status

        foreach ($responden as $index => $userId) {
            $status = $statusDistribusi[$index];

            // Tentukan jawaban sesuai dengan status yang dipilih
            $jawaban = match ($status) {
                1 => [
                    'status' => '1',
                    'status_kerja' => 'ya',
                    'durasi_kerja' => rand(1, 5), // Durasi kerja acak (1-5 tahun)
                    'nama_perusahaan' => 'Perusahaan ' . chr(rand(65, 90)) . chr(rand(65, 90)),
                    'pendapatan_bulanan' => rand(4000000, 10000000), // Rentang gaji acak
                    'hubungan_studi_pekerjaan' => ['sangat_erat', 'erat', 'cukup'][rand(0, 2)],
                    'syarat_pendidikan' => 'ya',
                    'jenis_perusahaan' => ['pemerintah', 'swasta', 'startup'][rand(0, 2)],
                ],
                2 => [
                    'status' => '2',
                    'info_tambahan' => 'Melanjutkan pendidikan di bidang ' . ['Komputer', 'Manajemen', 'Teknik'][rand(0, 2)],
                ],
                3 => [
                    'status' => '3',
                    'alasan' => ['menikah', 'sedang mencari pekerjaan', 'melanjutkan usaha keluarga'][rand(0, 2)],
                ],
                default => [],
            };

            // Insert jawaban ke tabel respon_kuesioner
            DB::table('respon_kuesioner')->insert([
                'event_kuesioner_id' => $eventKuesionerId,
                'user_id' => $userId,
                'jawaban' => json_encode($jawaban, JSON_PRETTY_PRINT), // Format lebih rapi
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
