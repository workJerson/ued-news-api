<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ArticleCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articleCategories = [
            [
                'id' => 1,
                'name' => 'Business',
                'description' => 'Business article category',
            ],
            [
                'id' => 2,
                'name' => 'Cars',
                'description' => 'Cars article category',
            ],
            [
                'id' => 3,
                'name' => 'Entertainment',
                'description' => 'Entertainment article category',
            ],
            [
                'id' => 4,
                'name' => 'Family',
                'description' => 'Family article category',
            ],
            [
                'id' => 5,
                'name' => 'Health',
                'description' => 'Health article category',
            ],
            [
                'id' => 6,
                'name' => 'Politics',
                'description' => 'Politics article category',
            ],
            [
                'id' => 7,
                'name' => 'Religion',
                'description' => 'Religion article category',
            ],
            [
                'id' => 8,
                'name' => 'Science',
                'description' => 'Science article category',
            ],
            [
                'id' => 9,
                'name' => 'Sports',
                'description' => 'Sports article category',
            ],
            [
                'id' => 10,
                'name' => 'Technology',
                'description' => 'Technology article category',
            ],
            [
                'id' => 11,
                'name' => 'Travel',
                'description' => 'Travel article category',
            ],
            [
                'id' => 12,
                'name' => 'Video',
                'description' => 'Video article category',
            ],
            [
                'id' => 13,
                'name' => 'World',
                'description' => 'World article category',
            ],
            [
                'id' => 14,
                'name' => 'News',
                'description' => 'News article category',
            ],
        ];

        foreach ($articleCategories as $articleCategory) {
            $articleCategoryObject = ArticleCategory::firstOrCreate(['id' => $articleCategory['id']], $articleCategory);
            if (!$articleCategoryObject->wasRecentlyCreated) {
                $articleCategoryObject->update(Arr::only($articleCategory, ['name', 'description']));
            }
        }
    }
}
