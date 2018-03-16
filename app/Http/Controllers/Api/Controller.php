<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Auth\AuthManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as ApiController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;

class Controller extends ApiController
{
    use ValidatesRequests;
    /**
     * @var AuthManager
     * */
    protected $auth ;


    /**
     * @var User
     * */
    protected $user =null;


    public function __construct()
    {
        $this->auth = app('auth');
        //$this->user();
    }

    protected function user() : User
    {
        return $this->user ? $this->user : ($this->user = \Request::user());
    }

    /**
     * @param Builder|HasMany|Model $query
     * @param bool $search
     * @param array $columns
     * @return array
     * */
    protected function buildList($query,bool $search = null, $columns = ['*'])
    {
        $page = Input::get('page', 1);
        $perPage = Input::get('per_page', 10);
        if($search){
            $data = $query->paginate($perPage, 'page', $page);
        }else{
            $data = $query->paginate($perPage, $columns, 'page', $page);
        }
        return $data;
    }

    protected function valid(array $input, array $rules, array $messages = [], array $customAttributes = []){
        $this->getValidationFactory()
            ->make($input, $rules, $messages, $customAttributes)
            ->validate();

        return collect($input)->only(collect($rules)->keys()->map(function ($rule) {
            return Str::contains($rule, '.') ? explode('.', $rule)[0] : $rule;
        })->unique()->toArray());
    }
}