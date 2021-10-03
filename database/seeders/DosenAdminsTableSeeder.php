<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DosenAdminsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dosen_admins')->delete();
        
        \DB::table('dosen_admins')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'nip' => '12345',
                'nama' => 'Zhafron Adani Kautsar',
                'created_at' => '2021-10-03 07:43:45',
                'updated_at' => '2021-10-03 07:43:45',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 2,
                'nip' => '197601182003122003',
                'nama' => 'Felicia Sylviana, ST., MM',
                'created_at' => '2021-10-03 07:43:45',
                'updated_at' => '2021-10-03 07:43:45',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 3,
                'nip' => '198106062005011001',
                'nama' => 'VIKTOR HANDRIANUS PRANATAWIJAYA, S.T ,M.T',
                'created_at' => '2021-10-03 07:53:42',
                'updated_at' => '2021-10-03 07:53:42',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 4,
                'nip' => '198110032006042001',
                'nama' => 'ENNY DWI OKTAVIYANI, S.T ,M.Kom',
                'created_at' => '2021-10-03 07:54:08',
                'updated_at' => '2021-10-03 07:54:08',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 5,
                'nip' => '197606242005011015',
                'nama' => 'RONY TEGUH, M.T ,Ph.D',
                'created_at' => '2021-10-03 07:54:26',
                'updated_at' => '2021-10-03 07:54:26',
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 6,
                'nip' => '198207172003122002',
                'nama' => 'WIDIATRY, S.T ,M.T',
                'created_at' => '2021-10-03 07:54:45',
                'updated_at' => '2021-10-03 07:54:45',
            ),
        ));
        
        
    }
}