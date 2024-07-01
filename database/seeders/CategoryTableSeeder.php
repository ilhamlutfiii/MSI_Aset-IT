<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=array(
            array(
                'title'=>'Perangkat Keras',
                'slug'=>'Perangkat-Keras',
                'photo'=>'/storage/photos/1/Kategori/38685891880331.jpg',
                'summary'=>'Aset Perangkat Keras',
                'is_parent'=>'1',
                'parent_id'=>null,
                'status'=>'active'
            ),
            array(
                'title'=>'Perangkat Lunak',
                'slug'=>'Perangkat-Lunak',
                'photo'=>'/storage/photos/1/Kategori/3c6c25f73dccd1967c4794eadd3483a0.jpg',
                'summary'=>'Aset Perangkat Lunak',
                'is_parent'=>'1',
                'parent_id'=>null,
                'status'=>'active',
            ),
            array(
                'title'=>'Laptop',
                'slug'=>'Laptop',
                'photo'=>'/storage/photos/1/Kategori/lenovo-ideapad-slim3-14a.jpg',
                'summary'=>'Aset Laptop',
                'is_parent'=>'0',
                'parent_id'=>'1',
                'status'=>'active',
            ),
        );
    
        DB::table('categories')->insert($data);
    }
}
