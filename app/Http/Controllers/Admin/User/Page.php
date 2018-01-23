<?php
namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Renders\Grid;

class Page extends BasePage
{
    public function __construct()
    {
        $this->setBoxTitle('商城用户管理');
        parent::__construct();
    }

    protected function filter(Grid\Filter $filter)
    {
        $filter->like('nickname', '管理昵称');
        $filter->like('mobile', '手机号码');
        $filter->between('created_at', '注册时间')->datetime();
        parent::filter($filter); // TODO: Change the autogenerated stub
    }

    protected function buildGrid(Grid $grid)
    {
        $grid->disableCreation();
        $grid->disableActions();
        $grid->disableRowSelector();
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
        $grid->roles('角色')->display(function ($roles){
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
}