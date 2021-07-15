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
                'name' => 'Sample Tag 1',
            ],
            [
                'id' => 2,
                'name' => 'Sample Tag 2',
            ],
            [
                'id' => 3,
                'name' => 'Sample Tag 3',
            ],
            [
                'id' => 4,
                'name' => 'Sample Tag 4',
            ],
            [
                'id' => 5,
                'name' => 'Sample Tag 5',
            ],
        ];

        foreach ($tags as $tag) {
            $tagObject = Tags::firstOrCreate(['id' => $tag['id']], $tag);
            if (!$tagObject->wasRecentlyCreated) {
                $tagObject->update(Arr::only($tag, [
                    'name',
                ]));
            }
        }
    }
}
