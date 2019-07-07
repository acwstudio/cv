<?php

use App\Post;
use App\PostTranslation;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* @var $factory \Illuminate\Database\Eloquent\Factory */
        factory(User::class, 30)->create()->each(function($u) {
            /** @var Permission $u */
            if ($u->id == 1) {
                $u->assignRole('admin');
            } elseif($u->id > 1 && $u->id < 4) {
                $u->assignRole('moderator');
            } elseif($u->id > 3 && $u->id < 6) {
                $u->assignRole('writer');
            } else {
                $u->assignRole('user');
            }
        });

        $fakerRU = Faker\Factory::create('ru_RU');
        $fakerEN = Faker\Factory::create('en_GB');

        factory(Post::class, 30)->create(['user_id' => 1])->each(function ($p) use($fakerRU, $fakerEN) {

            factory(PostTranslation::class)->create([
                'post_id' => $p->id,
                'locale' => 'ru',
                'title' => $fakerRU->name,
                'body' => $fakerRU->realText(500),
            ]);
            factory(PostTranslation::class)->create([
                'post_id' => $p->id,
                'locale' => 'en',
                'title' => $fakerEN->name,
                'body' => $fakerEN->realText(500),
            ]);

        });
    }
}
