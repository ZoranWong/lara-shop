<?php

namespace App\Services;

use Illuminate\Validation\ValidationException as ExceptionContract;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Log;

/**
 * 响应
 */
class AjaxResponse
{
    /**
     * AJAX异常返回
     *
     * @author Jason
     * @date   2017-03-02
     * @param  \Exception  $exception 异常
     * @param  integer     $code  状态
     * @return array
     */
    public static function exceptionAjax(Exception $exception, $code = 200)
    {
        $error = '';
        if ($exception instanceof ExceptionContract) {
            $error = $exception->getMessage();
        }

        Log::info(
            "response",
            [
                'code'     => $exception->getCode(),
                'response' => $exception->getMessage(),
            ]
        );

        return [
            'hasError' => true,
            'success'  => false,
            'error'    => $error,
            'code'     => $code,
            'data'     => [],
        ];
    }

    /**
     * AJAX错误返回
     *
     * @author Jason
     * @date   2017-03-02
     * @param  array  $error 异常
     * @param  integer     $code  状态
     * @return array
     */
    public static function errorAjax($error, $code = 400)
    {
        return [
            'hasError' => true,
            'success'  => false,
            'error'    => $error,
            'code'     => $code,
            'data'     => [],
        ];
    }

    /**
     * AJAX返回
     *
     * @author Jason
     * @date   2017-03-02
     * @param  mixed     $content 返回内容
     * @param  integer   $status  状态
     * @return array
     */
    public static function ajax($content, $code = 200)
    {
        if ($content instanceof Arrayable) {
            $content = $content->toArray();
        }

        $result = [
            'hasError' => false,
            'success'  => true,
            'error'    => '',
            'code'     => $code,
        ];

        return $result + ['data' => $content];
    }
}
