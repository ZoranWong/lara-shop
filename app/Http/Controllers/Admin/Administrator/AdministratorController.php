<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\Support\Facades\Input;

class AdministratorController extends Controller
{
    //
    public function __construct(Page $page)
    {
        $this->page = $page;
        $page->setModel(User::class);
        parent::__construct(function (){
            $roles = Input::get('roles');

            $conditions = [
                ['whereHas' => ['roles', function(Builder $query) use($roles){
                    if($roles && !empty($roles)){
                        $query->whereIn('role.id', $roles);
                    }else{
                        $query->where('role.name', '!=', Role::SUPER)->where('role.name', '!=', Role::USER);
                    }
                }]]
            ];

            if($roles){
                $this->page->roles = $roles;
                unset(app('request')['roles']);
            }else{
                $conditions[] = ['orWhereDoesntHave' => ['roles']];
            }
            return $conditions;
        });
    }
}
