<?php

namespace App\Providers;


use App\Services\AjaxResponse;
use Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // ajax接口返回宏
        Response::macro('ajax', function ($mContent = [], $iAjaxStatus = 200, $iStatus = 200, array $aHeaders = [], $iOptions = 0) {
            return response()->json(AjaxResponse::ajax($mContent, $iAjaxStatus), $iStatus, $aHeaders, $iOptions);
        });

        // 异常ajax接口返回宏
        Response::macro('exceptionAjax', function (Exception $mContent, $iAjaxStatus = 200, $iStatus = 200, array $aHeaders = [], $iOptions = 0) {
            return response()->json(AjaxResponse::exceptionAjax($mContent, $iAjaxStatus), $iStatus, $aHeaders, $iOptions);
        });

        // 错误ajax接口返回宏
        Response::macro('errorAjax', function ($error, $iAjaxStatus = 200, $iStatus = 200, array $aHeaders = [], $iOptions = 0) {
            return response()->json(AjaxResponse::errorAjax($error, $iAjaxStatus), $iStatus, $aHeaders, $iOptions);
        });
        // api接口返回宏
        Response::macro('api', function ($mContent = [], $iAjaxStatus = 200, $iStatus = 200, array $aHeaders = [], $iOptions = 0) {
            return response()->json(AjaxResponse::ajax($mContent, $iAjaxStatus), $iStatus, $aHeaders, $iOptions);
        });

        // 错误ajax接口返回宏
        Response::macro('errorApi', function ($error, $iAjaxStatus = 200, $iStatus = 200, array $aHeaders = [], $iOptions = 0) {
            return response()->json(AjaxResponse::errorAjax($error, $iAjaxStatus), $iStatus, $aHeaders, $iOptions);
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