<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=array(
            array(
                'unit_nama'=>'UP Muara Tawar',
            ),
            array(
                'unit_nama'=>'UP Brantas',
            ),
        );
    
        DB::table('units')->insert($data);
    }
}
