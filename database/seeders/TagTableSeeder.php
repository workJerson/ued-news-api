<?php

namespace Database\Seeders;

use App\Models\Tags;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                'id' => 1,
                'name' => 'Trending',
            ],
            [
                'id' => 2,
                'name' => 'Happy',
            ],
            [
                'id' => 3,
                'name' => 'War',
            ],
            [
                'id' => 4,
                'name' => 'Cooking Shows',
            ],
            [
                'id' => 5,
                'name' => 'Philippines Today',
            ],
        ];

        foreach ($tags as $tag) {
            $tagObject = Tags::firstOrCreate(['id' => $tag['id']], $tag);
            if (!$tagObject->wasRecentlyCreated) {
                $tagObject->update(Arr::only($tag, [
                    'name',
                ]));
            }
            $tagObject->slug = $tagObject->name;
            $tagObject->save();
        }
    }
}
