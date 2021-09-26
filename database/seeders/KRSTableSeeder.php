<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KRSTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('k_r_s')->delete();

        \DB::table('k_r_s')->insert([
            0 => [
                'id' => 1,
                'mahasiswa_id' => 1,
                'tahun_ajaran_id' => 2,
                'mata_kuliah_id' => 1,
                'semester' => '1',
                'created_at' => '2021-09-25 10:02:19',
                'updated_at' => '2021-09-25 10:02:19',
            ],
            1 => [
                'id' => 2,
                'mahasiswa_id' => 2,
                'tahun_ajaran_id' => 1,
                'mata_kuliah_id' => 2,
                'semester' => '2',
                'created_at' => '2021-09-25 10:02:19',
                'updated_at' => '2021-09-25 10:02:19',
            ],
            2 => [
                'id' => 3,
                'mahasiswa_id' => 1,
                'tahun_ajaran_id' => 1,
                'mata_kuliah_id' => 1,
                'semester' => '1',
                'created_at' => '2021-09-25 10:07:46',
                'updated_at' => '2021-09-25 10:07:46',
            ],
            3 => [
                'id' => 4,
                'mahasiswa_id' => 1,
                'tahun_ajaran_id' => 1,
                'mata_kuliah_id' => 2,
                'semester' => '1',
                'created_at' => '2021-09-25 10:07:48',
                'updated_at' => '2021-09-25 10:07:48',
            ],
            4 => [
                'id' => 5,
                'mahasiswa_id' => 1,
                'tahun_ajaran_id' => 1,
                'mata_kuliah_id' => 3,
                'semester' => '1',
                'created_at' => '2021-09-25 15:04:10',
                'updated_at' => '2021-09-25 15:04:10',
            ],
            5 => [
                'id' => 6,
                'mahasiswa_id' => 1,
                'tahun_ajaran_id' => 3,
                'mata_kuliah_id' => 3,
                'semester' => '1',
                'created_at' => '2021-09-25 15:44:18',
                'updated_at' => '2021-09-25 15:44:18',
            ],
        ]);
    }
}
