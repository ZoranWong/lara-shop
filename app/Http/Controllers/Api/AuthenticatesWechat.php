<?php
namespace App\Http\Controllers\Api;

use App\Auth\WechatGuard;

trait AuthenticatesWechat
{
    protected function guard() : WechatGuard
    {
        return $this->auth->guard();
    }


}