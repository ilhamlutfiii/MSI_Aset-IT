<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BidangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=array(
            array(
                'bidang_name'=>'Operasi'
            ),
            array(
                'bidang_name'=>'Pemeliharaan',
            ),
        );
    
        DB::table('bidangs')->insert($data);
    }
}
