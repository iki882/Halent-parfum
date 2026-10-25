<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'woody' => Category::query()->firstOrCreate(
                ['slug' => 'woody'],
                ['name' => 'Woody', 'description' => 'Aroma kayu yang hangat dan elegan'],
            ),
            'floral' => Category::query()->firstOrCreate(
                ['slug' => 'floral'],
                ['name' => 'Floral', 'description' => 'Aroma bunga yang segar dan manis'],
            ),
            'fresh' => Category::query()->firstOrCreate(
                ['slug' => 'fresh'],
                ['name' => 'Fresh', 'description' => 'Aroma citrus dan air yang menyegarkan'],
            ),
            'men-series' => Category::query()->firstOrCreate(
                ['slug' => 'men-series'],
                ['name' => 'Men Series', 'description' => 'Koleksi parfum pria'],
            ),
            'women-series' => Category::query()->firstOrCreate(
                ['slug' => 'women-series'],
                ['name' => 'Women Series', 'description' => 'Koleksi parfum wanita'],
            ),
            'unisex' => Category::query()->firstOrCreate(
                ['slug' => 'unisex'],
                ['name' => 'Unisex', 'description' => 'Koleksi parfum unisex'],
            ),
        ];

        $brands = [
            'chanel' => Brand::query()->firstOrCreate(
                ['slug' => 'chanel'],
                ['name' => 'Chanel', 'description' => 'Brand parfum mewah asal Prancis'],
            ),
            'dior' => Brand::query()->firstOrCreate(
                ['slug' => 'dior'],
                ['name' => 'Dior', 'description' => 'Brand fashion dan parfum ternama dunia'],
            ),
            'halent-signature' => Brand::query()->firstOrCreate(
                ['slug' => 'halent-signature'],
                ['name' => 'Halent Signature', 'description' => 'Koleksi eksklusif Halent Parfum'],
            ),
        ];

        $products = [
            [
                'brand' => 'chanel',
                'category' => 'woody',
                'name' => 'Bleu de Chanel',
                'slug' => 'bleu-de-chanel',
                'description' => 'Parfum pria dengan aroma kayu aromatik yang tahan lama.',
                'price' => 2200000,
                'stock' => 15,
                'image' => null,
            ],
            [
                'brand' => 'dior',
                'category' => 'fresh',
                'name' => 'Dior Sauvage',
                'slug' => 'dior-sauvage',
                'description' => 'Aroma fresh dengan sentuhan bergamot dan ambroxan.',
                'price' => 2100000,
                'stock' => 10,
                'image' => null,
            ],
            [
                'brand' => 'halent-signature',
                'category' => 'women-series',
                'name' => 'Water Kiss Eau De Parfum',
                'slug' => 'water-kiss-edp',
                'description' => 'Aroma segar buah dan sentuhan floral yang elegan.',
                'price' => 47679,
                'stock' => 20,
                'image' => 'assets/hero-parfume.jpeg',
            ],
            [
                'brand' => 'halent-signature',
                'category' => 'women-series',
                'name' => 'Black Opium',
                'slug' => 'black-opium',
                'description' => 'Aroma kopi khas dengan wangi mewah.',
                'price' => 47679,
                'stock' => 20,
                'image' => 'assets/black-opium.jpeg',
            ],
            [
                'brand' => 'halent-signature',
                'category' => 'women-series',
                'name' => 'She Loved',
                'slug' => 'she-loved',
                'description' => 'Aroma lembut dan tahan lama.',
                'price' => 47679,
                'stock' => 20,
                'image' => 'assets/she-loved.jpeg',
            ],
            [
                'brand' => 'halent-signature',
                'category' => 'men-series',
                'name' => 'Ventus',
                'slug' => 'ventus',
                'description' => 'Aroma maskulin yang tahan lama untuk aktivitas sehari-hari.',
                'price' => 47679,
                'stock' => 20,
                'image' => 'assets/ventus.jpeg',
            ],
            [
                'brand' => 'halent-signature',
                'category' => 'women-series',
                'name' => 'Water Kiss',
                'slug' => 'water-kiss',
                'description' => 'Aroma lembut dan segar.',
                'price' => 47679,
                'stock' => 20,
                'image' => 'assets/water-kiss.jpeg',
            ],
            [
                'brand' => 'halent-signature',
                'category' => 'men-series',
                'name' => 'HMNS Alpha',
                'slug' => 'hmns-alpha',
                'description' => 'Aroma kuat dan tahan lama.',
                'price' => 47679,
                'stock' => 20,
                'image' => 'assets/hmns-alpha.jpeg',
            ],
            [
                'brand' => 'halent-signature',
                'category' => 'men-series',
                'name' => 'Hawas Ice',
                'slug' => 'hawas-ice',
                'description' => 'Aroma segar yang tahan lama.',
                'price' => 47679,
                'stock' => 20,
                'image' => 'assets/hawas-ice.jpeg',
            ],
            [
                'brand' => 'halent-signature',
                'category' => 'men-series',
                'name' => 'One Million Lucky',
                'slug' => 'one-milion-lucky',
                'description' => 'Aroma maskulin dengan karakter khas.',
                'price' => 47679,
                'stock' => 20,
                'image' => 'assets/one-milion-lucky.jpeg',
            ],
            [
                'brand' => 'halent-signature',
                'category' => 'men-series',
                'name' => 'Water Man',
                'slug' => 'water-man',
                'description' => 'Aroma segar dengan karakter maskulin.',
                'price' => 47679,
                'stock' => 20,
                'image' => 'assets/water-man.jpeg',
            ],
        ];

        foreach ($products as $product) {
            Product::query()->firstOrCreate(
                ['slug' => $product['slug']],
                [
                    'brand_id' => $brands[$product['brand']]->id,
                    'category_id' => $categories[$product['category']]->id,
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'image' => $product['image'],
                    'is_active' => true,
                ],
            );
        }
    }
}
