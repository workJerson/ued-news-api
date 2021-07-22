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
                'name' => 'Entertainment',
                'description' => 'Entertainment article category',
            ],
            [
                'id' => 3,
                'name' => 'Video',
                'description' => 'Video article category',
            ],
            [
                'id' => 4,
                'name' => 'News',
                'description' => 'News article category',
            ],
        ];

        foreach ($articleCategories as $articleCategory) {
            $articleCategoryObject = ArticleCategory::firstOrCreate(['id' => $articleCategory['id']], $articleCategory);
            if (!$articleCategoryObject->wasRecentlyCreated) {
                $articleCategoryObject->update(Arr::only($articleCategory, ['name', 'description']));
            }
            $articleCategoryObject->slug = $articleCategoryObject->name;
            $articleCategoryObject->save();
        }
    }
}
