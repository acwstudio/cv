<?php

use Illuminate\Database\Seeder;

/**
 * Class CategoriesTableSeeder
 */
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = factory(\App\Category::class)->create();
        dd($category);
        for ($i = 0; $i < 5; $i++) {

            $category_id = DB::table('categories')->insertGetId([
                'alias' => 'category_' . $i,
                'created_at' => date('Y-m-d, H-i-s'),
            ]);

            DB::table('category_translations')->insert([
                'category_id' => $category_id,
                'locale' => 'en',
                'name' => 'Category ' . $i,
            ]);

            DB::table('category_translations')->insert([
                'category_id' => $category_id,
                'locale' => 'ru',
                'name' => 'Категория ' . $i,
            ]);

        }
    }
}
