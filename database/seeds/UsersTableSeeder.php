<?php

use App\User;
use Illuminate\Database\Seeder;

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
        $dummy_path = public_path('/') . config('cv-images.preset.user.dummy') . 'user_pics';
        $image_path = public_path('/') . config('cv-images.preset.user.path');
        
        if(!File::exists($image_path)) {
            File::makeDirectory($image_path, 0755, true, true);
        }

        $files = File::files($image_path);

        if(count($files) === 0) {
            dump($image_path);
            File::copyDirectory($dummy_path, $image_path);
        }

        /* @var $factory \Illuminate\Database\Eloquent\Factory */
        factory(User::class, 10)->create()->each(function($u) {
            /** @var User $u */
            $i = $u->id;
            $u->update(['image_name' => 'user_' . $i]);

            if ($u->id == 1) {
                $u->assignRole('admin');
                $u->update([
                    'email' => 'admin@admin.loc',
                    'password' => Hash::make(config('cv-default.admin_password')),
                ]);
            } elseif($u->id > 1 && $u->id < 4) {
                $u->assignRole('moderator');
                $u->update([
                    'password' => Hash::make(config('cv-default.admin_password')),
                ]);
            } elseif($u->id > 3 && $u->id < 6) {
                $u->assignRole('writer');
                $u->update([
                    'password' => Hash::make(config('cv-default.admin_password')),
                ]);
            } elseif($u->id === 7) {
                $u->assignRole('user');
                $u->update([
                    'email' => 'user@user.loc',
                    'password' => Hash::make('12345678'),
                ]);
            } else {
                $u->assignRole('user');
            }
        });

    }
}
