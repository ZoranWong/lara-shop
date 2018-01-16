<?php
namespace App\Auth;

use App\Models\Token;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
class MiniProgramGuard extends SessionGuard
{
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

    public function __construct($name, UserProvider $provider, Session $session, Request $request = null)
    {
        parent::__construct($name, $provider, $session, $request);
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user() : Authenticatable
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();
        $token = Token::where('token', $token)->where('expire_in', '>', time())->fisrt();
        if (! empty($token)) {
            $user = $this->provider->retrieveByCredentials(
                ['id' => $token['user_id']]
            );
        }

        if(!$user){
            $user = parent::user();
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

        return $token;
    }
}