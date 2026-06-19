<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\NoteRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Repositories\Contracts\NoteRepositoryInterface;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
   public function register(): void
        {
            $this->app->bind(
                NoteRepositoryInterface::class,
                NoteRepository::class
            );
        }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
        {
            RateLimiter::for('api-notes', function (Request $request) {

                return Limit::perMinute(60)
                    ->by($request->ip());
            });
        }
}
