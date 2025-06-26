<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilAlumni;
use App\Models\ProfilAdmin;

class AkunUserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat admin
        $admin = User::create([
            'email' => 'admin@example.com',
            'nama' => 'Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved',
            'foto' => null,
        ]);

        ProfilAdmin::create([
            'user_id' => $admin->id,
            'no_telepon' => '081234567890',
            'jabatan' => 'Manager',
        ]);

        // Membuat alumni
        $jurusanList = [
            'Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi',
            'Teknik Elektro', 'Psikologi', 'Hukum', 'Kedokteran',
            'Arsitektur', 'Pendidikan Bahasa Inggris'
        ];

        $statuses = [
            'approved' => 100,
            'pending' => 10,
            'rejected' => 50,
        ];

        foreach ($statuses as $status => $count) {
            for ($i = 0; $i < $count; $i++) {
                // Buat user
                $user = User::create([
                    'email' => "alumni.$status$i@example.com",
                    'nama' => "Alumni $status $i",
                    'password' => Hash::make('password'),
                    'role' => 'alumni',
                    'status' => $status,
                    'foto' => null,
                ]);

                // Buat profil alumni
                ProfilAlumni::create([
                    'user_id' => $user->id,
                    'nim' => 'NIM' . rand(100000000, 999999999),
                    'jurusan' => $jurusanList[array_rand($jurusanList)],
                    'tahun_masuk' => rand(2010, 2020),
                    'tahun_lulus' => rand(2014, 2025),
                    'no_telepon' => '08' . rand(1111111111, 9999999999),
                    'alamat_rumah' => 'Jl. Random No. ' . rand(1, 100),
                    'ipk' => round(rand(300, 400) / 100, 2),
                    'linkedin' => 'https://linkedin.com/in/alumni' . $user->id,
                    'instagram' => 'https://instagram.com/alumni' . $user->id,
                    'email_alternatif' => "alumni.$status$i.alt@example.com",
                ]);
            }
        }
    }
}
