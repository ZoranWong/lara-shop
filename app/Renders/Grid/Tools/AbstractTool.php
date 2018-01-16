<?php

namespace App\Renders\Grid\Tools;

use App\Renders\Grid;
use Illuminate\Contracts\Support\Renderable;

abstract class AbstractTool implements Renderable
{
    /**
     * @var Grid
     */
    protected $grid;

    /**
     * Set parent grid.
     *
     * @param Grid $grid
     *
     * @return $this
     */
    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function render();

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
