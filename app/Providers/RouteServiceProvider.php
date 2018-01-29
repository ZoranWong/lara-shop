<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $domains = [];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->domains = config('domain');
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::domain($this->domains['web'])
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(
                base_path('routes/auth.php')
            );
        Route::domain($this->domains['web'])
             ->middleware('web')
             ->namespace($this->namespace.'\Admin')
             ->group(base_path('routes/web.php'));
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::domain($this->domains['admin'])
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(
                base_path('routes/auth.php')
            );
        Route::domain($this->domains['admin'])
            ->middleware('web')
            ->namespace($this->namespace.'\Admin')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::domain($this->domains['api'])
             ->middleware('api')
             ->namespace($this->namespace.'\Api')
             ->group(base_path('routes/api.php'));
    }
}
