<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Admin\BaseController as Controller;

class UserController extends Controller
{
    //
    //
    public function __construct(Page $page)
    {
        $this->page = $page;
        $page->setModel(User::class);
        parent::__construct(function (){
            $conditions = [
                ['whereHas' => ['roles', function(Builder $query) {
                    $query->where('role.name', Role::USER);
                }]]
            ];
            return $conditions;
        });
    }
}
