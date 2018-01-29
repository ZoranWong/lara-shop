<?php
namespace App\Auth;

use App\Models\Token;
use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class MiniProgramUserProvider extends EloquentUserProvider
{
    public function retrieveByToken($identifier, $token)
    {
        $model = $this->createModel();

        $model = $model->where($model->getAuthIdentifierName(), $identifier)->first();

        if (! $model) {
            return null;
        }

        $token = $model->tokens()->where('token', $token)->first();

        return $token ? $model : null;
    }

    /**
     * Create a new instance of the model.
     *
     * @return User
     */
    public function createModel() : User
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }

    public function updateToken(User $user, Token $token)
    {
        $user->tokens()->save($token);
    }
}