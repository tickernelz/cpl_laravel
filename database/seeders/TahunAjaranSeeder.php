<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TahunAjaran::create([
            'id' => '1',
            'tahun' => '2020/2021',
        ]);

        TahunAjaran::create([
            'id' => '2',
            'tahun' => '2019/2020',
        ]);
    }
}
