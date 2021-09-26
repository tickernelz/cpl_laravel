<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mahasiswa::create([
            'id' => '1',
            'nim' => 'DBC116999',
            'nama' => 'Sari',
            'angkatan' => '2016',
        ]);

        Mahasiswa::create([
            'id' => '2',
            'nim' => 'DBC117999',
            'nama' => 'Tono',
            'angkatan' => '2017',
        ]);
    }
}
