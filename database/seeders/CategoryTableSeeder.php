<?php

namespace Database\Seeders;

use App\Models\Category;

class CategoryTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryTitles = config('const.categories');

        foreach ($categoryTitles as $title) {
            Category::factory()->create([
                'title' => $title
            ]);
        }
    }
}
