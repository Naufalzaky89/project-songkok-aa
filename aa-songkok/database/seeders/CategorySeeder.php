<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Peci Hitam',
                'slug'        => 'peci-hitam',
                'description' => 'Koleksi peci hitam polos berkualitas tinggi untuk berbagai kesempatan formal dan non-formal.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Peci NU',
                'slug'        => 'peci-nu',
                'description' => 'Peci khas Nahdlatul Ulama dengan desain tradisional yang elegan.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Songkok Premium',
                'slug'        => 'songkok-premium',
                'description' => 'Songkok premium berbahan velvet dan bahan pilihan untuk tampilan mewah.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Songkok Bordir',
                'slug'        => 'songkok-bordir',
                'description' => 'Songkok dengan hiasan bordir indah menggunakan benang emas dan perak.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Songkok Putih',
                'slug'        => 'songkok-putih',
                'description' => 'Songkok putih suci cocok untuk ibadah dan acara keagamaan.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Songkok Custom',
                'slug'        => 'songkok-custom',
                'description' => 'Pesan songkok sesuai keinginan Anda dengan desain dan ukuran custom.',
                'is_active'   => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
