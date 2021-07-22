<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ArticleCategoryTableSeeder::class);
        // $this->call(TagTableSeeder::class);
        // $this->call(ArticleTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
