<?php

namespace App\Providers;

use App\Services\MenuBuilderService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\AdminLte;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Services\StoreService;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        $config = $this->app['config'];
        /**
         * @var \Event $events
         * */
        $events = $this->app['events'];

        View::composer('layouts.page', function (\Illuminate\View\View $view) use ($config,$events){

            $view->with('storeInfo', StoreService::getCurrentStore());
            $adminLte = new AdminLte(
                $config['adminlte.filters'],
                $events,
                $this->app
            );

            $view->with('adminlte', $adminLte);
            $events->forget(BuildingMenu::class);
            $events->listen(BuildingMenu::class, function (BuildingMenu $event) use ($config) {
                $menu = MenuBuilderService::menus();
                call_user_func_array([$event->menu, 'add'], $menu);
            });
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}