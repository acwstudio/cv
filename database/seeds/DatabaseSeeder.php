<?php

;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use App\Permission;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");

            $this->call(RolesPermissionsSeeder::class);
            $this->command->info('Some Roles and Permissions data seeded.');

            $this->call(UsersTableSeeder::class);
            $this->command->info('Some Users data seeded.');

            $this->call(TagsTableSeeder::class);
            $this->command->info('Some Tags data seeded.');

            $this->call(CategoriesTableSeeder::class);
            $this->command->info('Some Categories data seeded.');

            $this->call(PostsTableSeeder::class);
            $this->command->info('Some Posts data seeded.');

        } else {
            $this->command->info('Action canceled.');
        }
    }
}
