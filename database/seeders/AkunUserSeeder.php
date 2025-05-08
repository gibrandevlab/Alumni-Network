<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AkunUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk semua kombinasi enum di tabel users
        $roles = ['admin', 'alumni'];
        $statuses = ['pending', 'approved', 'rejected'];

        foreach ($roles as $role) {
            foreach ($statuses as $status) {
                // Buat user
                $userId = DB::table('users')->insertGetId([
                    'email' => "$role.$status@example.com",
                    'nama' => ucfirst($role) . ' ' . ucfirst($status),
                    'password' => Hash::make('password'),
                    'role' => $role,
                    'status' => $status,
                    'foto' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Buat profil sesuai role
                if ($role === 'admin') {
                    DB::table('profil_admin')->insert([
                        'user_id' => $userId,
                        'no_telepon' => '081234567890',
                        'jabatan' => 'Manager',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } elseif ($role === 'alumni') {
                    DB::table('profil_alumni')->insert([
                        'user_id' => $userId,
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
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
