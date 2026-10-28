<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            ['title' => 'Koleksi Peci Premium Terbaru', 'description' => 'Temukan koleksi peci dan songkok premium pilihan untuk tampilan lebih elegan dan berwibawa.', 'order' => 1],
            ['title' => 'Diskon Spesial Ramadhan', 'description' => 'Dapatkan diskon hingga 30% untuk semua koleksi songkok pilihan kami selama bulan Ramadhan.', 'order' => 2],
            ['title' => 'Songkok Custom Pesanan Khusus', 'description' => 'Buat songkok dengan desain sesuai keinginan Anda. Tersedia layanan custom bordir dan logo.', 'order' => 3],
        ];

        foreach ($banners as $b) {
            Banner::create([
                'title'       => $b['title'],
                'description' => $b['description'],
                'image'       => 'banners/banner-default.jpg',
                'order'       => $b['order'],
                'is_active'   => true,
            ]);
        }
    }
}
