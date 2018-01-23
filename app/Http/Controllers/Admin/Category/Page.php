<?php
namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Renders\Facades\SectionContent;
use App\Renders\Form;
use App\Renders\Grid;

class Page extends BasePage
{
    public function __construct()
    {
        $this->setBoxTitle('分类管理');
        parent::__construct();
    }

    protected function filter(Grid\Filter $filter)
    {
        $filter->like('name', '名称');
        parent::filter($filter); // TODO: Change the autogenerated stub
    }

    protected function buildForm(Form $form, $id = null): BasePage
    {
        $form->text('id', 'ID');
        $form->text('name', '分类名称');
        $form->number('排序');
        return parent::buildForm($form, $id); // TODO: Change the autogenerated stub
    }

    protected function buildGrid(Grid $grid)
    {
//        $grid->disableCreation();
        $grid->name('分类名称<span class="label label-success" style="margin-left:20px"><a href="javascript:void(0)"'.
            ' id="add-category" style="color:#fff">新建分组</a>')->display(function ($value){
                return "<a href='javascript:void(0)' class = 'editable'>{$value}</a>";
        });
        $grid->sort('排序')->sortable();
        $grid->column('merchandises_count', '商品数量')->sortable();
        $grid->created_at('创建时间')->sortable();
        return parent::buildGrid($grid); // TODO: Change the autogenerated stub
    }
}