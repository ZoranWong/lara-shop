<?php
namespace App\Http\Controllers\Api;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller as ApiController;

class Controller extends ApiController
{
    /**
     * @var AuthManager
     * */
    protected $auth ;

    public function __construct(AuthManager $authManager)
    {
        $this->auth = $authManager;
    }
}