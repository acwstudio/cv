<?php

use Illuminate\Database\Seeder;

/**
 * Class TagsTableSeeder
 */
class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {

            $tag_id = DB::table('tags')->insertGetId([
                'alias' => 'tag_' . $i,
                'created_at' => date('Y-m-d, H-i-s'),
            ]);

            DB::table('tag_translations')->insert([
                'tag_id' => $tag_id,
                'locale' => 'en',
                'name' => 'Tag ' . $i,
            ]);

            DB::table('tag_translations')->insert([
                'tag_id' => $tag_id,
                'locale' => 'ru',
                'name' => 'Тэг ' . $i,
            ]);
        }
    }
}
