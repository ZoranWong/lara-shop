<?php
namespace App\Http\Controllers\Admin\Common;

use App\Renders\Facades\SectionContent;
use App\Renders\Form;
use App\Renders\Grid;
use App\Renders\Layout\Content;
use App\Renders\Tree;
use App\Renders\Widgets\Box;
use App\Renders\Widgets\Tab;
use Illuminate\Contracts\Support\Renderable;

abstract class BasePage implements Renderable
{
    /**
     * @var Content
     * */
    protected $content = null;
    /**
     * @var Box $box
     * */
    protected $box = null;

    protected $css = null;
    protected $js = null;

    protected $conditionCallback = null;
    /**
     * @var string $model
     * */
    protected $model = null;


    public function __construct()
    {
        $this->css = new Css();
        Form::registerBuiltinFields();

    }

    public function conditions(\Closure $callback)
    {
        $this->conditionCallback = $callback;
    }

    protected function setBoxTitle($title)
    {
        $this->box = (new Box())->title($title);
        $this->content = SectionContent::content(function (Content $content){
            $content->row($this->box);
        });
    }


    public function table()
    {
        $this->box->content($this->grid()->render());
        return $this;
    }

    public function edit($id )
    {
        $form = $id ? $this->form($id)->edit($id) : $this->form($id);
        $this->box->content($form);
        return $this;
    }

    public function create( )
    {
        $form = $this->form();
        $this->box->content($form);
        return $this;
    }


    public function render()
    {
        // TODO: Implement render() method.
        return $this->content
            ->render();
    }

    public function form($id = null)
    {
        return SectionContent::form($this->model, function (Form $form) use( $id ){
            $this->buildForm($form, $id);
        });
    }

    /**
     * build form
     * @param Form $form
     * @param int $id
     * @return BasePage
     * */
    protected function buildForm(Form $form, $id = null) : BasePage
    {
        return $this;
    }

    protected function buildGrid(Grid $grid)
    {
        return '';
    }

    public function grid()
    {
        return SectionContent::grid($this->model, function (Grid $grid){
            if ($this->conditionCallback) {
                $grid->model()->addConditions(call_user_func($this->conditionCallback));
            }
            $grid->filter(function (Grid\Filter $filter){
                $filter->disableIdFilter();
                $this->filter($filter);
            });
            $this->buildGrid($grid);
        });
    }

    protected function filter(Grid\Filter $filter)
    {

    }

    public function tree()
    {
        return SectionContent::tree($this->model, function (Tree $tree){
            $this->buildTree($tree);
        });
    }

    public function buildTree( Tree $tree)
    {
        return $this;
    }


    public function showTabs()
    {
        $this->box->content($this->tab());
        return $this;
    }

    public function tab()
    {
        return SectionContent::tab(function (Tab $tab){
            $this->buildTab($tab);
        });
    }

    public function buildTab (Tab $tab) : BasePage
    {
        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->render();
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * build template
     * @return string
     * */
    public function template() : string
    {
        return "";
    }
}