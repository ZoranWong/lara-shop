<?php

namespace App\Renders\Layout;

use Encore\Admin\Layout\Column;
use Illuminate\Contracts\Support\Renderable as Contents;

class Row extends \Encore\Admin\Layout\Row
{
    /**
     * @var Column[]
     */
    protected $columns = [];

    /**
     * @var integer
     * */
    protected $height = null;

    /**
     * Row constructor.
     *
     * @param string|Content $content
     */
    public function __construct($content = '')
    {
        parent::__construct($content);
    }

    /**
     * @param int $value
     * @return int
     * */
    public function height(int $value = null) : int
    {
        if ($value){
            $this->height = $value;
        }
        return $this->height;
    }

    /**
     * Add a column.
     *
     * @param array|int $width
     * @param string|Content $content
     */
    public function column($width, $content)
    {
        $column = new \App\Renders\Layout\Column($content, $width);

        $this->addColumn($column);
    }

    /**
     * @param Column $column
     */
    protected function addColumn(Column $column)
    {
        $this->columns[] = $column;
    }

    /**
     * Build row column.
     */
    public function build()
    {
        $this->startRow();

        foreach ($this->columns as $column) {
            $column->build();
        }

        $this->endRow();
    }

    /**
     * Start row.
     */
    protected function startRow()
    {
        echo "<div class=\"row h-{$this->height}\">";
    }

    /**
     * End column.
     */
    protected function endRow()
    {
        echo '</div>';
    }
}
