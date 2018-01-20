<?php
namespace App\Renders\Widgets;


use Illuminate\Contracts\Support\Renderable;

class BootstrapTable extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'components.widgets.bootstrap-table';

    protected $id = '';

    protected $class = '';

    public function setID(string $id)
    {
        $this->id = $id;
    }

    public function setClass(string $class)
    {
        $this->class = $class;
    }

    protected function script()
    {
        return <<<SCRIPT
$().
SCRIPT;

    }
    public function render()
    {
        // TODO: Implement render() method.
        return view($this->view, [
            'id' => $this->id,
            'class' => $this->class,
            'attributes' => $this->formatAttributes()
        ]);
    }
}