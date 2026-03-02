<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagTitles = config('const.categories');

        foreach ($tagTitles as $title) {
            Tag::factory()->create([
                'title' => $title
            ]);
        }
    }
}
