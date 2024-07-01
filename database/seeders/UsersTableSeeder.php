<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $data=array(
            array(
                'user_nid'=>'123456789zjy',
                'user_nama'=>'Admin',
                'jabatan_id'=>'1',
                'bidang_id'=>'1',
                'fungsi_id'=>'1',
                'password'=>Hash::make('123456789zjy'),
                'photo'=>'/storage/photos/1/User/2041720025 000.jpg',
                'role'=>'admin',
                'status'=>'active'
            ),
            array(
                'user_nid'=>'987654321zjy',
                'user_nama'=>'User',
                'jabatan_id'=>'2',
                'bidang_id'=>'2',
                'fungsi_id'=>'2',
                'password'=>Hash::make('987654321zjy'),
                'photo'=>'/storage/photos/1/User/IMG_2978.JPG',
                'role'=>'User',
                'status'=>'active',
            ),
        );
    
        DB::table('users')->insert($data);
        
    }
}
