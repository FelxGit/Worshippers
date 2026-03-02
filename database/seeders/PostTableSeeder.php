<?php

namespace Database\Seeders;

use App\Models\Post;

class PostTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \DB::table('users')->where('username', parent::USERNAME)->first();
        $categories = \DB::table('categories')->get();

        foreach ($categories as $category) {
            Post::factory()->create([
                'user_id' => $user->id,
                'category_id' => $category->id
            ]);
        }
    }
}
