<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            'description'=>"Website Sistem Informasi Aset IT PLN Nusantara Power Up Muara Tawar adalah platform yang disesuaikan untuk memudahkan manajemen yang efisien dari aset teknologi informasi perusahaan. Dengan fokus pada kebutuhan unik perusahaan, website ini menyediakan fitur lengkap untuk pengelolaan inventaris perangkat keras dan perangkat lunak, pelacakan pemeliharaan, pemantauan ketersediaan aset, serta generasi laporan dan analisis untuk pengambilan keputusan strategis. Dengan lapisan keamanan yang kuat dan manajemen akses pengguna yang fleksibel, website ini bertujuan untuk meningkatkan efisiensi operasional, memperpanjang umur pakai aset, dan meningkatkan visibilitas serta transparansi atas aset IT di PLN Nusantara Power Up Muara Tawar.",

            'short_des'=>"Website Sistem Informasi Aset IT PLN Nusantara Power Up Muara Tawar: Solusi terkini untuk manajemen efisien aset teknologi informasi. Melalui fitur canggih, kami mempermudah pemantauan inventaris, pelacakan pemeliharaan, dan analisis data untuk pengambilan keputusan yang lebih baik. Dengan fokus pada keamanan dan aksesibilitas, kami membantu meningkatkan efisiensi operasional dan memaksimalkan kinerja aset IT perusahaan.",

            'photo'=>"/storage/photos/1/logo msi 2.png",
            'logo'=>'/storage/photos/1/logo msi 3.png',
            'address'=>"Jl. PLTGU Muara Tawar No. 1, Segarajaya, Kec. Tarumajaya, Kabupaten Bekasi, Jawa Barat 17212, Indonesia",
            'email'=>"k3muaratawar@gmail.com",
            'phone'=>"(021)-88990052",
        );
        DB::table('settings')->insert($data);
    }
}
