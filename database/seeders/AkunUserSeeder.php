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
use App\Models\EventKuesioner;

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

        // Seed PendaftaranEvent
        $pendaftaran = PendaftaranEvent::create([
            'event_id' => $event->id,
            'user_id' => User::where('role', 'alumni')->first()->id,
            'status' => 'menunggu',
        ]);

        // Seed PembayaranEvent
        PembayaranEvent::create([
            'pendaftaran_event_id' => $pendaftaran->id,
            'status_pembayaran' => 'berhasil',
            'midtrans_transaction_id' => 'MID1234567890',
            'jumlah' => 50000,
            'waktu_pembayaran' => now(),
        ]);

        // Seed Messages
        Message::create([
            'user_id' => User::first()->id,
            'message' => 'Welcome to the Alumni Network!',
            'media_path' => null,
            'media_type' => null,
        ]);

        // Seed EventKuesioner
        EventKuesioner::create([
            'judul_event' => 'Tracer Study 2025',
            'deskripsi_event' => 'A study to track alumni progress.',
            'foto' => null,
            'tahun_mulai' => 2020,
            'tahun_akhir' => 2025,
            'tahun_lulusan' => 2019,
        ]);

        // Seed ResponKuesioner
        ResponKuesioner::create([
            'event_kuesioner_id' => EventKuesioner::first()->id,
            'jawaban' => json_encode(['question1' => 'answer1', 'question2' => 'answer2']),
            'user_id' => User::where('role', 'alumni')->first()->id,
        ]);
    }
}
