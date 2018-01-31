<?php
namespace App\Auth;
use Illuminate\Auth\AuthManager as BaseAuthManager;
use Illuminate\Contracts\Auth\Guard;

class AuthManager extends BaseAuthManager
{

    public function createMiniProgramDriver($name, $config) : Guard
    {
        $provider = $this->createMiniProgramProvider($config['provider.miniProgram'] ?? null);
        logger('user guard', config('auth.defaults'));
        $guard = new MiniProgramGuard($provider, $this->app['request']);

        // When using the remember me functionality of the authentication services we
        // will need to be set the encryption instance of the guard, which allows
        // secure, encrypted cookie values to get generated for those cookies.
        if (method_exists($guard, 'setCookieJar')) {
            $guard->setCookieJar($this->app['cookie']);
        }

        if (method_exists($guard, 'setDispatcher')) {
            $guard->setDispatcher($this->app['events']);
        }

        if (method_exists($guard, 'setRequest')) {
            $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));
        }

        return $guard;
    }

    protected function createMiniProgramProvider($config)
    {
        return new MiniProgramUserProvider($this->app['hash'], $config['model']);
    }
}