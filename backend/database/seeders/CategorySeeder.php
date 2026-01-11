<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // JANGAN truncate karena ada FK dari barangs
        Category::query()->delete();

        Category::insert([
            [
                'kode' => 'CAT-BESI',
                'nama' => 'Besi',
                'deskripsi' => 'Kategori material besi',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'CAT-CAT',
                'nama' => 'Cat',
                'deskripsi' => 'Kategori cat dan pelapis',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'CAT-AKS',
                'nama' => 'Aksesoris',
                'deskripsi' => 'Kategori aksesoris bangunan',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
