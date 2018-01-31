<?php
namespace App\Auth;

use App\Models\Token;
use App\Models\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\SupportsBasicAuth;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MiniProgramGuard implements Guard
{
    use GuardHelpers;
    /**
     * The name of the query string item from the request containing the API token.
     *
     * @var string
     */
    protected $inputKey = 'token';
    /**
     * The name of the header string item from the request header containing the API token.
     *
     * @var string
     */
    protected $headerKey = 'MP-AUTH-TOKEN';

    /**
     * The name of the token "column" in persistent storage.
     *
     * @var string
     */
    protected $storageKey = 'token';

    /**
     * The name of the token expire "column" in persistent storage.
     *
     * @var string
     */
    protected $expireInKey = 'expire_in';

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request = null;

    public function __construct(UserProvider $provider, Request $request = null)
    {
        $this->request = $request;
        $this->provider = $provider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();
        $time = time();
        logger('user login', config('auth.defaults'));
        $token = Token::token($token, $time);
        if (!!$token && ! empty($token)) {
            $user = User::find($token['user_id']);
        }

        return $this->user = $user;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest() : string
    {
        $token = $this->request->query($this->inputKey);

        if (empty($token)) {
            $token = $this->request->input($this->inputKey);
        }

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->header($this->headerKey);
        }

        return $token ? $token : '';
    }

    /**
     * Create a new "remember me" token for the user if one doesn't already exist.
     *
     * @param  User  $user
     * @return void
     */
    protected function ensureTokenIsSet(User $user)
    {
        if (empty($user->getToken())) {
            $this->cycleToken($user);
        }
    }

    public function login(User $user, $remember = false)
    {
        $this->cycleToken($user);
        $this->setUser($user);
    }

    public function validate(array $credentials = [])
    {
        // TODO: Implement validate() method.
    }

    /**
     * Refresh the "remember me" token for the user.
     *
     * @param  User  $user
     * @return void
     */
    protected function cycleToken(User $user)
    {

        $user->setToken($token = new Token([
            'token' => bcrypt($user->toJson()),
            'expire_in' => time() + config('auth.token.ttl'),
        ]));

        $this->getProvider()->updateToken($user, $token);
    }

    protected function getProvider() : MiniProgramUserProvider
    {
        return $this->provider;
    }
}