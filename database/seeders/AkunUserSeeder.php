<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilAlumni;
use App\Models\ProfilAdmin;
use App\Models\RelasiAlumni;

class AkunUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'alumni'];
        $statuses = ['pending', 'approved', 'rejected'];
        $jurusanList = [
            'Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi',
            'Teknik Elektro', 'Psikologi', 'Hukum', 'Kedokteran',
            'Arsitektur', 'Pendidikan Bahasa Inggris'
        ];
        $firstNames = [
            'Aditya', 'Budi', 'Cahaya', 'Dika', 'Eka', 'Faisal',
            'Galih', 'Hanif', 'Irma', 'Jaka', 'Kiki', 'Lala',
            'Miko', 'Nanda', 'Oka', 'Putri', 'Qori', 'Raka', 'Sari', 'Taufiq'
        ];
        $middleNames = [
            'Ananda', 'Bagus', 'Cahyo', 'Dewi', 'Eko', 'Fauzi',
            'Gita', 'Hadi', 'Ika', 'Joni', 'Kurnia', 'Lestari',
            'Munandar', 'Nur', 'Oktaviani', 'Prasetyo', 'Qurrota', 'Rizki', 'Satria', 'Tri'
        ];
        $lastNames = [
            'Aulia', 'Bastian', 'Cahyono', 'Dewanto', 'Erlangga', 'Fatimah',
            'Guntara', 'Harsono', 'Indarto', 'Juliani', 'Kusuma', 'Lestari',
            'Maulana', 'Nugroho', 'Oktavius', 'Pratama', 'Qisthi', 'Ramadhani', 'Suryanto', 'Wijaya'
        ];

        $alumniUsers = [];

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
                    for ($i = 0; $i < 20; $i++) {
                        $tahunMasuk = rand(2010, 2020);
                        $tahunLulus = $tahunMasuk + rand(4, 7);

                        // Generate a random name
                        $name = $firstNames[array_rand($firstNames)];
                        if (rand(0, 1)) {
                            $name .= ' ' . $middleNames[array_rand($middleNames)];
                        }
                        $name .= ' ' . $lastNames[array_rand($lastNames)];

                        $profilAlumni = ProfilAlumni::create([
                            'user_id' => $user->id,
                            'nim' => 'NIM' . rand(100000000, 999999999),
                            'jurusan' => $jurusanList[array_rand($jurusanList)],
                            'tahun_masuk' => $tahunMasuk,
                            'tahun_lulus' => $tahunLulus,
                            'no_telepon' => '08' . rand(1111111111, 9999999999),
                            'alamat_rumah' => 'Jl. Random No. ' . rand(1, 100),
                            'ipk' => round(rand(300, 400) / 100, 2),
                            'linkedin' => 'https://linkedin.com/in/' . strtolower(str_replace(' ', '', $name)),
                            'instagram' => 'https://instagram.com/' . strtolower(str_replace(' ', '', $name)),
                            'email_alternatif' => strtolower(str_replace(' ', '.', $name)) . '@example.com',
                        ]);

                        $alumniUsers[] = $profilAlumni->user_id;
                    }
                }
            }
        }

        // Seed RelasiAlumni
        $relationTypes = ['teman', 'kolega', 'mentor', 'lainnya'];
        for ($i = 0; $i < 50; $i++) {
            $utama = $alumniUsers[array_rand($alumniUsers)];
            // Pilih teman yang berbeda dari utama
            do {
                $teman = $alumniUsers[array_rand($alumniUsers)];
            } while ($teman === $utama);

            RelasiAlumni::create([
                'alumni_utama_id' => $utama,
                'alumni_teman_id' => $teman,
                'tipe_hubungan' => $relationTypes[array_rand($relationTypes)],
                'deskripsi' => 'Hubungan ' . $relationTypes[array_rand($relationTypes)] . ' yang erat.',
            ]);
        }
    }
}
