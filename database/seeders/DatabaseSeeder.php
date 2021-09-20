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
            RoleSeeder::class,
            UserSeeder::class,
            DosenAdminSeeder::class,
            MahasiswaSeeder::class,
            TahunAjaranSeeder::class,
            MataKuliahSeeder::class,
            KRSSeeder::class,
            CplSeeder::class,
            CpmkSeeder::class,
            BtpSeeder::class,
        ]);
    }
}
