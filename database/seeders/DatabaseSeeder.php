<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AkunUserSeeder::class,
            KuesionerAlumniSeeder::class,
            WorkshopLokerSeeder::class, // tambahkan seeder workshop & loker
        ]);
    }
}
