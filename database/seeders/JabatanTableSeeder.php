<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=array(
            array(
                'jabatan_name'=>'Senior Manager'
            ),
            array(
                'jabatan_name'=>'Manager',
            ),
        );
    
        DB::table('jabatans')->insert($data);
    }
}
