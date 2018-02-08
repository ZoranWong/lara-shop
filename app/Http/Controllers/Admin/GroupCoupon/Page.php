<?php
namespace App\Http\Controllers\Admin\GroupCoupon;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Models\Group;
use App\Models\GroupCoupon;
use App\Renders\Facades\SectionContent;
use App\Renders\Form;
use App\Renders\Grid;

class Page extends BasePage
{
    public function __construct()
    {
        $this->setBoxTitle('团购活动管理');
        parent::__construct();
    }

    protected function filter(Grid\Filter $filter)
    {
        $filter->like('store.name', '店铺名称');
        $filter->like('code', '团购活动编号');
        $filter->like('name', '团购活动名称');
        $filter->equal('status', '团购活动状态')->select(GroupCoupon::STATUS_CN);
        $filter->between('price', '团购优惠价格')->currency([
            'min' => 0.00,
            'step' => 0.01
        ]);
        $filter->equal('start_time', '团购开始时间');
        $filter->equal('end_time', '团购结束时间');
        parent::filter($filter); // TODO: Change the autogenerated stub
    }

    public function edit($id )
    {
        $form =  $this->form($id);
        $this->box->content($form);
        return $this;
    }


    public function form($id = null)
    {
        if($id){
            $title = '编辑团购活动';
        }else{
            $title = '创建团购活动';
        }
        return new Editor($id, $title);
    }


    public function buildGrid(Grid $grid)
    {
        $grid->id('ID')->sortable();
        $grid->name('活动名称');
        $grid->column('price', '团购价格')->display(function ($value){
            return sprintf('%.2f', $value);
        });
        $grid->column('leader_price', '团长价格')->display(function ($value){
            return $value > 0 ? sprintf('%.2f', $value) : '--';
        });
        $grid->column('groups', '团购成团数量')->display(function ($value){
            return collect($value)->where('status', Group::STATUS['PATCHED'])->count();
        });

        $grid->start_time('开始时间')->display(function ($value){
            return date('Y-m-d h:i:s', $value);
        });
        $grid->end_time('结束时间')->display(function ($value){
            return date('Y-m-d h:i:s', $value);
        });

        $grid->status('状态')->display(function ($value){
            $status = GroupCoupon::STATUS_CN[$value];
            return <<<STATUS
<span class = "label label-default">{$status}</span>
STATUS;

        });

        $grid->with(['id' => 'permission-table']);
        return parent::buildGrid($grid); // TODO: Change the autogenerated stub
    }
}