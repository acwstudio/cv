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
        $this->app->bind('App\Repositories\Contracts\UserInterface', 'App\Repositories\DB_MySQL\UserRepository');
        $this->app->bind('App\Repositories\Contracts\PostInterface', 'App\Repositories\DB_MySQL\PostRepository');
    }
}
