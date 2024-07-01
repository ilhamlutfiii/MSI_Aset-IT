<?php

use App\Models\Bidang;
use App\Models\Category;
use App\Models\Jabatan;
use Illuminate\Database\Seeder;

use Database\Seeders\JabatanTableSeeder;
use Database\Seeders\BidangTableSeeder;
use Database\Seeders\UnitTableSeeder;
use Database\Seeders\FungsiTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CategoryTableSeeder;
use Database\Seeders\AsetTableSeeder;
use Database\Seeders\SettingTableSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(JabatanTableSeeder::class);
        $this->call(BidangTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(FungsiTableSeeder::class); 
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(AsetTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        
    }
}
