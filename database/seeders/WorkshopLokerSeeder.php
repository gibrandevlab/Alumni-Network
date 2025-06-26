<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class WorkshopLokerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('event_pengembangan_karir')->insert([
            [
                'status' => 'aktif',
                'judul_event' => 'Workshop Pengembangan Diri',
                'deskripsi_event' => 'Workshop untuk meningkatkan soft skill dan hard skill alumni.',
                'tanggal_mulai' => '2025-07-10',
                'tanggal_akhir_pendaftaran' => '2025-07-08',
                'waktu_mulai' => '2025-07-10 09:00:00',
                'waktu_selesai' => '2025-07-10 16:00:00',
                'dilaksanakan_oleh' => 'Alumni Center',
                'tipe_event' => 'event',
                'lokasi' => 'Aula Kampus A',
                'tools' => 'Zoom, Google Meet',
                'foto' => null,
                'link' => 'https://example.com/workshop',
                'harga_daftar' => 50000,
                'harga_diskon' => 25000,
                'maksimal_peserta' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
            [
                'status' => 'aktif',
                'judul_event' => 'Bursa Kerja Alumni',
                'deskripsi_event' => 'Event bursa kerja khusus alumni dengan berbagai perusahaan mitra.',
                'tanggal_mulai' => '2025-08-15',
                'tanggal_akhir_pendaftaran' => '2025-08-13',
                'waktu_mulai' => '2025-08-15 08:00:00',
                'waktu_selesai' => '2025-08-15 15:00:00',
                'dilaksanakan_oleh' => 'Career Center',
                'tipe_event' => 'loker',
                'lokasi' => 'Aula Kampus B',
                'tools' => 'Offline',
                'foto' => null,
                'link' => 'https://example.com/loker',
                'harga_daftar' => 0,
                'harga_diskon' => 0,
                'maksimal_peserta' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
