<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Peci Hitam
            ['category' => 'peci-hitam', 'name' => 'Peci Hitam Polos Classic', 'price' => 45000, 'stock' => 100, 'size' => '56,57,58,59,60', 'featured' => true,
             'description' => 'Peci hitam polos classic berbahan beludru berkualitas. Cocok untuk acara formal, pengajian, maupun keseharian. Tersedia berbagai ukuran.'],
            ['category' => 'peci-hitam', 'name' => 'Peci Hitam Polos Premium', 'price' => 75000, 'stock' => 80, 'size' => '56,57,58,59,60,61', 'featured' => true,
             'description' => 'Peci hitam polos premium dengan bahan beludru grade A. Jahitan rapi dan kuat, cocok untuk penggunaan sehari-hari maupun acara resmi.'],
            ['category' => 'peci-hitam', 'name' => 'Peci Hitam Polos Anak', 'price' => 35000, 'stock' => 60, 'size' => '50,51,52,53,54,55', 'featured' => false,
             'description' => 'Peci hitam polos khusus anak-anak. Ringan dan nyaman dipakai, cocok untuk kegiatan sekolah, TPA, dan acara keagamaan.'],

            // Peci NU
            ['category' => 'peci-nu', 'name' => 'Peci NU Standar', 'price' => 55000, 'stock' => 90, 'size' => '56,57,58,59,60', 'featured' => true,
             'description' => 'Peci khas Nahdlatul Ulama dengan desain tradisional. Berbahan beludru hitam berkualitas dengan logo NU yang elegan.'],
            ['category' => 'peci-nu', 'name' => 'Peci NU Deluxe', 'price' => 95000, 'stock' => 50, 'size' => '57,58,59,60', 'featured' => true,
             'description' => 'Peci NU deluxe dengan bahan premium dan logo NU bordir emas. Pilihan tepat untuk acara resmi organisasi.'],

            // Songkok Premium
            ['category' => 'songkok-premium', 'name' => 'Songkok Velvet Premium', 'price' => 150000, 'stock' => 40, 'size' => '57,58,59,60,61', 'featured' => true,
             'description' => 'Songkok berbahan velvet mewah dengan tampilan elegan. Cocok untuk acara pernikahan, wisuda, dan acara formal lainnya.'],
            ['category' => 'songkok-premium', 'name' => 'Songkok Suede Premium', 'price' => 185000, 'stock' => 30, 'size' => '57,58,59,60', 'featured' => false,
             'description' => 'Songkok berbahan suede premium dengan tekstur halus dan mewah. Tersedia dalam pilihan hitam pekat.'],
            ['category' => 'songkok-premium', 'name' => 'Songkok Kombinasi Premium', 'price' => 225000, 'stock' => 25, 'size' => '58,59,60', 'featured' => true,
             'description' => 'Songkok kombinasi bahan velvet dan suede dengan aksen emas. Tampilan super mewah untuk momen spesial.'],

            // Songkok Bordir
            ['category' => 'songkok-bordir', 'name' => 'Songkok Bordir Emas', 'price' => 175000, 'stock' => 35, 'size' => '57,58,59,60', 'featured' => true,
             'description' => 'Songkok dengan hiasan bordir benang emas yang indah. Motif klasik yang memperindah tampilan Anda.'],
            ['category' => 'songkok-bordir', 'name' => 'Songkok Bordir Perak', 'price' => 165000, 'stock' => 35, 'size' => '57,58,59,60', 'featured' => false,
             'description' => 'Songkok dengan hiasan bordir benang perak elegan. Cocok untuk acara pernikahan dan formal.'],
            ['category' => 'songkok-bordir', 'name' => 'Songkok Bordir Full', 'price' => 250000, 'stock' => 20, 'size' => '58,59,60', 'featured' => true,
             'description' => 'Songkok dengan bordir penuh motif khas nusantara menggunakan benang emas dan perak. Karya seni yang bisa Anda kenakan.'],

            // Songkok Putih
            ['category' => 'songkok-putih', 'name' => 'Songkok Putih Haji', 'price' => 65000, 'stock' => 75, 'size' => '56,57,58,59,60', 'featured' => true,
             'description' => 'Songkok putih pilihan untuk ibadah haji, umroh, dan kegiatan keagamaan. Bahan linen premium yang sejuk dan nyaman.'],
            ['category' => 'songkok-putih', 'name' => 'Songkok Putih Sholat', 'price' => 45000, 'stock' => 90, 'size' => '56,57,58,59,60,61', 'featured' => false,
             'description' => 'Songkok putih untuk sholat sehari-hari. Ringan, nyaman, dan mudah dicuci.'],

            // Songkok Custom
            ['category' => 'songkok-custom', 'name' => 'Songkok Custom Logo', 'price' => 200000, 'stock' => 50, 'size' => 'Custom', 'featured' => true,
             'description' => 'Pesan songkok custom dengan logo organisasi atau instansi Anda. Minimum order 10 pcs. Hubungi kami untuk detail lebih lanjut.'],
            ['category' => 'songkok-custom', 'name' => 'Songkok Custom Nama', 'price' => 175000, 'stock' => 50, 'size' => 'Custom', 'featured' => false,
             'description' => 'Songkok custom dengan bordir nama sesuai keinginan. Cocok untuk souvenir pernikahan dan hadiah spesial.'],
        ];

        foreach ($products as $p) {
            $category = Category::where('slug', $p['category'])->first();
            Product::create([
                'category_id'  => $category->id,
                'name'         => $p['name'],
                'slug'         => Str::slug($p['name']) . '-' . Str::random(5),
                'description'  => $p['description'],
                'price'        => $p['price'],
                'stock'        => $p['stock'],
                'size'         => $p['size'],
                'is_active'    => true,
                'is_featured'  => $p['featured'],
            ]);
        }
    }
}
