<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepoServiceProvider
 *
 * @package App\Providers
 */
class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            'App\Repositories\Contracts\UserInterface',
            'App\Repositories\DB_MySQL\UserRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\PostInterface',
            'App\Repositories\DB_MySQL\PostRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\TagInterface',
            'App\Repositories\DB_MySQL\TagRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\CategoryInterface',
            'App\Repositories\DB_MySQL\CategoryRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\RoleInterface',
            'App\Repositories\DB_MySQL\RoleRepository'
        );
    }
}
