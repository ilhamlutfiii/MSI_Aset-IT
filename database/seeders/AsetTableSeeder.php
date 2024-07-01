<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AsetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=array(
            array(
                'title'=>'Laptop 01',
                'slug'=>'Laptop-01',
                'summary'=>'Laptop Lenovo',
                'description'=>'Lenovo Ideapad Slim 3',
                'cat_id'=>'1',
                'child_cat_id'=>'3',
                'photo'=>'/storage/photos/1/Aset/7cfafdce420d430d82961eb6213574e1.jpeg',
                'stock'=>'1',
                'rentang'=>'10',
                'status'=>'active'
            )
        );
    
        DB::table('asets')->insert($data);
    }
}
