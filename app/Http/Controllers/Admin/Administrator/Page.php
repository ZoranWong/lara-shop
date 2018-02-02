<?php
namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Models\Permission;
use App\Models\Role;
use App\Renders\Facades\SectionContent;
use App\Renders\Form;
use App\Renders\Grid;
use Illuminate\Support\Facades\Input;

class Page extends BasePage
{
    public $roles = [];
    public function __construct()
    {
        $this->setBoxTitle('系统管理员管理');
        parent::__construct();
    }

    protected function filter(Grid\Filter $filter)
    {
        $filter->like('nickname', '管理昵称');
        $filter->like('mobile', '手机号码');
        $filter->between('created_at', '注册时间')->datetime();
        $filter->equal('roles', '角色')->multipleSelect(Role::where('name', '!=', Role::SUPER)->where('name', '!=', Role::USER)
            ->get()->pluck('display_name', 'id'))->default($this->roles);
        //$filter->equal('permission.id', '权限')->multipleSelect(Permission::all()->pluck('name', 'id'));
        parent::filter($filter); // TODO: Change the autogenerated stub
    }

    protected function buildGrid(Grid $grid)
    {
        $grid->id('ID');
        $grid->column('head_image_url', '头像')->display(function ($url){
            if($url){
                return <<<IMAGE
                <div style = "width:42px; height:42px; margin: auto;">
                    <img style = "width: 100%; vertical-align: middle;" src = "{$url}">
                </div>
IMAGE;
            }else{
                return '';
            }
        });
        $grid->nickname('昵称');
        $grid->mobile('手机号码');
        $grid->roles('授权角色')->display(function ($roles){
            $roleStr = '';
            if($roles){
                foreach ($roles as $role){
                    $roleStr .= "<span class='label label-success'>{$role['display_name']}</span>";
                }
                return $roleStr;
            }else{
                return "<span class='label label-default'>未开放</span>";
            }

        });
        $grid->created_at('注册时间');
        return parent::buildGrid($grid); // TODO: Change the autogenerated stub
    }

    protected function buildForm(Form $form, $id = null): BasePage
    {
        SectionContent::link(asset('/vue/css/app.css'));
        SectionContent::jsLoad(asset('/vue/js/app.js'));
        if(!Input::input('password', null)){
            unset(app('request')['password']);
        }
        if($id){
            $form->display('id', 'ID');
        }
        $form->text('nickname', '昵称')->rules('required');
        $form->mobile('mobile', '手机号码')->rules('required');
        $form->vueUpload('head_image_url', '头像')->attribute(['url' => '/ajax/user/avatar', 'id' => 'app'])->rules('required');
        $form->password('password', trans('admin.password'))->rules($id ? 'confirmed' : 'required|confirmed');
        if(!$id){
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules($id ? '' : 'required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->ignore(['password_confirmation']);
        }

        $form->multipleSelect('roles', trans('admin.roles'))->options(Role::where('name', '!=', Role::SUPER)->where('name', '!=', Role::USER)
            ->get()->pluck('display_name', 'id'));
        //$form->multipleSelect('permissions', trans('admin.permissions'))->options(Permission::all()->pluck('name', 'id'));

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            }
        });
        return parent::buildForm($form, $id); // TODO: Change the autogenerated stub
    }
}