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
        factory(User::class, 10)->create()->each(function($u) {
            /** @var User $u */
            $i = $u->id - 1;
            $u->update(['image_name' => 'user-' . $i]);

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

    }
}
