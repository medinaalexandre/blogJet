<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = 'Agricultura';
        $category->save();

        $category = new Category();
        $category->name = 'Design';
        $category->save();

        $category = new Category();
        $category->name = 'Política';
        $category->save();

        $category = new Category;
        $category->name = 'Saúde';
        $category->save();

        $category = new Category;
        $category->name = 'Tecnologia';
        $category->save();
    }
}
