<?php

use Illuminate\Database\Seeder;

class CategoryPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = \App\Category::all();

        \App\Post::all()->each(function ($post) use ($categories){
            $post->categories()->attach(
                $categories->random(rand(1,5))->pluck(('id'))->toArray()
            );
        });
    }
}
