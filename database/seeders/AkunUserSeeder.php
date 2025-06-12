<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilAlumni;
use App\Models\ProfilAdmin;

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
    }
}
