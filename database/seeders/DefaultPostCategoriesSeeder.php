<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class DefaultPostCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostCategory::insert([
            [
                'name'       => 'Tanpa Kategori',
                'slug'       => 'tanpa-kategori',
                'is_default' => true,
            ],
            [
                'name'       => 'Berita Ditjen SDA',
                'slug'       => 'ditjen-sda',
                'is_default' => true,
            ],
        ]);

        //  Set tanpa kategori id = 0
        PostCategory::whereSlug('tanpa-kategori')->update(['id' => 0]);
    }
}
