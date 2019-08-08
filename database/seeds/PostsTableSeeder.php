<?php

use Illuminate\Database\Seeder;

/**
 * Class PostsTableSeeder
 */
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fakerRU = Faker\Factory::create('ru_RU');
        $fakerEN = Faker\Factory::create('en_GB');

        $users = DB::table('users')->get();
        $categories = DB::table('categories')->pluck('id', 'alias');
        $tags = DB::table('tags')->pluck('id', 'alias');

        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                $post_id = DB::table('posts')->insertGetId([
                    'user_id' => $user->id,
                    'category_id' => $categories->random(),
                    'image_name' => 'post_',
                    'image_extension' => 'jpg',
                    'created_at' => date('Y-m-d H-i-s'),
                ]);

                DB::table('posts')->where('id', $post_id)->update([
                    'image_name' => 'post_' . $post_id,
                    'image_extension' => 'jpg',
                ]);

                $num_tag = rand(1, 3);
                $post_tags = $tags->random($num_tag);

                foreach ($post_tags as $tag) {
                    DB::table('post_tag')->insert([
                        'post_id' => $post_id,
                        'tag_id' => $tag,
                    ]);
                }

                DB::table('post_translations')->insert([
                    'post_id' => $post_id,
                    'locale' => 'en',
                    'title' => $fakerEN->name,
                    'body' => $fakerEN->realText(500),
//                    'active' => 1,
                ]);

                DB::table('post_translations')->insert([
                    'post_id' => $post_id,
                    'locale' => 'ru',
                    'title' => $fakerRU->name,
                    'body' => $fakerRU->realText(500),
//                    'active' => 1,
                ]);
            }
        }
    }
}
