<?php

namespace App\Providers;

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
        // Switch case directive
        \Blade::extend(function($value, $compiler){
            $value = preg_replace('/(\s*)@switch\((.*)\)(?=\s)/', '$1<?php switch($2):', $value);
            $value = preg_replace('/(\s*)@endswitch(?=\s)/', '$1endswitch; ?>', $value);
            $value = preg_replace('/(\s*)@case\((.*)\)(?=\s)/', '$1case $2: ?>', $value);
            $value = preg_replace('/(?<=\s)@default(?=\s)/', 'default: ?>', $value);
            $value = preg_replace('/(?<=\s)@breakswitch(?=\s)/', '<?php break;', $value);
            return $value;
        });

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
                    logger('not array',[$value]);
                    return false;
                }
            }else{
                return true;
            }
            logger('value');
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
                    logger( 'not array');
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

        if($this->app->runningInConsole()){
            $this->app->register(\Encore\Admin\AdminServiceProvider::class);
        }
    }
}
