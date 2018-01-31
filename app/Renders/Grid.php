<?php
namespace App\Renders;

use App\Exceptions\Handler;
use App\Renders\Grid\Column;
use App\Renders\Grid\Displayers\Actions;
use App\Renders\Grid\Displayers\RowSelector;
use App\Renders\Grid\Exporter;
use App\Renders\Grid\Filter;
use App\Renders\Grid\Model;
use App\Renders\Grid\Tools;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Grid extends \Encore\Admin\Grid
{
    protected $view = "components.grid.table";

    /**
     * The grid data model instance.
     *
     * @var Model
     */
    protected $model;

    /**
     * @var Filter
     * */
    protected $filter = null;


    /**
     * Create a new grid instance.
     *
     * @param Eloquent $model
     * @param Closure  $builder
     */
    public function __construct(Eloquent $model, \Closure $builder)
    {
        $this->keyName = $model->getKeyName();
        $this->model = new Model($model);
        $this->columns = new Collection();
        $this->rows = new Collection();
        $this->builder = $builder;

        $this->setupTools();
        $this->setupFilter();
        $this->setupExporter();
    }
    /**
     * @var Model
     * */
    public function model() : Model
    {
        return $this->model;
    }
    /**
     * Setup grid tools.
     */
    public function setupTools()
    {
        $this->tools = new Tools($this);
    }

    /**
     * Setup grid filter.
     *
     * @return void
     */
    protected function setupFilter()
    {
        $this->filter = new Filter($this->model());
    }

    /**
     * Setup grid exporter.
     *
     * @return void
     */
    protected function setupExporter()
    {
        if ($scope = Input::get(Exporter::$queryName)) {
            $this->model()->usePaginate(false);

            call_user_func($this->builder, $this);

            (new Exporter($this))->resolve($this->exporter)->withScope($scope)->export();
        }
    }

    /**
     * Render export button.
     *
     * @return Tools\ExportButton
     */
    public function renderExportButton()
    {
        return new Tools\ExportButton($this);
    }

    public function renderFilterButton()
    {
        return new Tools\FilterButton($this);
    }

    /**
     * Get the grid paginator.
     *
     * @return mixed
     */
    public function paginator()
    {
        return new Tools\Paginator($this);
    }

    /**
     * Prepend checkbox column for grid.
     *
     * @return void
     */
    protected function prependRowSelectorColumn()
    {
        if (!$this->option('useRowSelector')) {
            return;
        }

        $grid = $this;

        $column = new Column(Column::SELECT_COLUMN_NAME, ' ');
        $column->setGrid($this);

        $column->display(function ($value) use ($grid, $column) {
            $actions = new RowSelector($value, $grid, $column, $this);

            return $actions->display();
        });

        $this->columns->prepend($column);
    }

    /**
     * Build the grid.
     *
     * @return void
     */
    public function build()
    {
        if ($this->builded) {
            return;
        }

        $data = $this->processFilter();

        $this->prependRowSelectorColumn();
        $this->appendActionsColumn();

        Column::setOriginalGridData($data);

        $this->columns->map(function (\Encore\Admin\Grid\Column $column) use (&$data) {
            $data = $column->fill($data);

            $this->columnNames[] = $column->getName();
        });

        $this->buildRows($data);

        $this->builded = true;
    }

    /**
     * Add `actions` column for grid.
     *
     * @return void
     */
    protected function appendActionsColumn()
    {
        if (!$this->option('useActions')) {
            return;
        }

        $grid = $this;
        $callback = $this->actionsCallback;
        $column = $this->addColumn('__actions__', trans('admin.action'));
        $column->display(function ($value) use ($grid, $column, $callback) {
            $actions = new Actions($value, $grid, $column, $this);

            return $actions->display($callback);
        });
    }

    /**
     * Add column to grid.
     *
     * @param string $column
     * @param string $label
     *
     * @return Column
     */
    protected function addColumn($column = '', $label = '')
    {
        $column = new Column($column, $label);
        $column->setGrid($this);

        return $this->columns[] = $column;
    }



    /**
     * Get the string contents of the grid view.
     *
     * @return string
     */
    public function render()
    {
        try {
            $this->build();
        } catch (\Exception $e) {
            return Handler::renderException($e);
        }

        $this->variables['id'] = str_random();
        return view($this->view, $this->variables())->render();
    }

    /**
     * Add variables to grid view.
     *
     * @param array $variables
     *
     * @return $this
     */
    public function with($variables = [])
    {
        $this->variables = array_merge($this->variables, $variables);

        return $this;
    }
}
