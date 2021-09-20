<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MataKuliah::create([
            'id' => '1',
            'kode' => '1DCP95432',
            'nama' => 'PBO',
        ]);

        MataKuliah::create([
            'id' => '2',
            'kode' => '1DCP95434',
            'nama' => 'Data Mining',
        ]);
    }
}
