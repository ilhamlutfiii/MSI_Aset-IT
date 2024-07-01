<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FungsiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=array(
            array(
                'unit_id'=>'1',
                'fungsi_name'=>'Manajemen'
            ),
            array(
                'unit_id'=>'1',
                'fungsi_name'=>'Rendal Operasi',
            ),
        );
    
        DB::table('fungsis')->insert($data);
    }
}
