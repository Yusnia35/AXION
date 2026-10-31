<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $user = Auth::user() ?? User::where('role', 'farm_manager')->first() ?? User::first();
            $workspace = $user?->workspace ?? Workspace::first();

            $view->with([
                'currentUser' => $user,
                'currentWorkspace' => $workspace,
            ]);
        });
    }
}
