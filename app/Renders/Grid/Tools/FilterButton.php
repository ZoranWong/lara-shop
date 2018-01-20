<?php
namespace App\Renders\Grid\Tools;

use App\Renders\Facades\SectionContent;
use App\Renders\Grid;
use App\Renders\Grid\Filter;

class FilterButton extends AbstractTool
{
    /**
     * @var string
     * */
    protected $id = '';

    /**
     * @var Filter
     * */
    protected $filter = null;

    /**
     * @var string
     * */
    protected $action = '';

    public function __construct(Grid $grid)
    {
        $this->id = str_random();
        $this->grid = $grid;
        $this->filter = $grid->getFilter();
    }

    protected function script()
    {
        return <<<SCRIPT
        
        $('body').on('click', '.filter-btn', function(event){
            {$this->filter->submit()}
        });
SCRIPT;

    }


    /**
     * Get url without filter queryString.
     *
     * @return string
     */
    protected function urlWithoutFilters()
    {
        $columns = [];

        /** @var Filter\AbstractFilter $filter * */
        foreach ($this->filter->filters() as $filter) {
            $columns[] = $filter->getColumn();
        }

        /** @var \Illuminate\Http\Request $request * */
        $request = \Request::instance();

        $query = $request->query();
        array_forget($query, $columns);

        $question = $request->getBaseUrl().$request->getPathInfo() == '/' ? '/?' : '?';

        return count($request->query()) > 0
            ? $request->url().$question.http_build_query($query)
            : $request->fullUrl();
    }

    /**
     * Set action of search form.
     *
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function render()
    {
        SectionContent::script($this->script());
        // TODO: Implement render() method.
        return view('components.filter.filter-button')->with([
            'id' => $this->id,
            'action'    => $this->action ?: $this->urlWithoutFilters()
        ])->render();
    }
}