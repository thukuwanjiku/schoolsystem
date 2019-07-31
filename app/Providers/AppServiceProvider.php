<?php

namespace App\Providers;

use App\DB\Students\StudentParent;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        Relation::morphMap([
            'user' => User::class,
            'parent' => StudentParent::class,
        ]);
    }
}
