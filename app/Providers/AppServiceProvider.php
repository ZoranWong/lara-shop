<?php

namespace App\Providers;

use App\Auth\AuthManager;
use App\Models\Merchandise;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('products', function ($attribute, $value, $parameters, $validator) {
            if ($value) {
                if(is_array($value)){
                    foreach ($value as $item){
                        if(is_float((float)$item['sell_price']) && is_integer((int) $item['stock_num']) && is_float((float)$item['market_price']) && is_array($item['spec_array'])){
//                        {name:"XX",id:"XX",value:"XX","tip":"XX"}
                            foreach ($item['spec_array'] as $spec){
                                return ($except =array_except($spec, ['name', 'id', 'value', 'tip'])) ? !count($except) : true;
                            }
                            return true;
                        }else{
                            return false;
                        }
                    }
                }else{
//                    logger('not array',[$value]);
                    return false;
                }
            }else{
                return true;
            }
//            logger('value');
            return false;
        });

        \Validator::extend('images', function ($attribute, $value, $parameters, $validator) {
            if ($value) {
                if(is_array($value)){
                    foreach ($value as $item){
                        if(!$item){
                            return false;
                        }
                    }
                    return true;
                }else{
//                    logger( 'not array');
                    return false;
                }
            }else{
                return true;
            }
        });

        \Validator::extend('spec_array', function ($attribute, $value, $parameters, $validator) {
            if ($value) {
                if(is_array($value)){
                    foreach ($value as $item){
                        //{name:"XX",id:"XX",value:{"XX":"XX"}}
                        return ($except =array_except($item, ['name', 'id', 'value'])) ? !count($except) : true;
                    }
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });

        \Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            if(preg_match("/^1\d{10}$/",$value)){
                return true;
            }else{
                return false;
            }
        });

        \Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            if(preg_match("/^1\d{10}$/",$value) || preg_match("/^0\d{2,3}-?\d{7,8}$/", $value)){
                return true;
            }else{
                return false;
            }
        });

        \Validator::extend('shopping_carts', function ($attribute, $value, $parameters, $validator) {
            $value = array_unique($value);
            return ShoppingCart::whereIn('id', $value)->count() == count($value);
        });

        \Validator::extend('order_num_limit', function($attribute, $value, $parameters, $validator){
            $merchandise = Merchandise::find($attribute['merchandise_id']);
            $product = null;
            if(isset($attribute['product_id'])){
                $product = Product::find($attribute['product_id']);
            }

            if($product){
                if($product->stock_num < $value || $merchandise->stock_num < $value){
                    return false;
                }
            }
            if($merchandise->stock_num < $value){
                return false;
            }

            return true;
        });
        \DB::listen(function (QueryExecuted $executed){
            \Log::debug($executed->sql, $executed->bindings);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->singleton('auth', function ($app) {
            $app['auth.loaded'] = true;
            return new AuthManager($app);
        });
        if($this->app->runningInConsole()){
            $this->app->register(\Encore\Admin\AdminServiceProvider::class);
        }
    }
}
