<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //import and define bootstrap ここ追加した
        Paginator::useBootstrap();

        // DEFINE GATE 後から足した
        Gate::define('admin', function($user){
            // admin id the name if the gate
            // $user is an instance of the USER MODEL (usually means the logged in user)
            return $user->role_id === User::ADMIN_ROLE_ID;
        });
    }
}
