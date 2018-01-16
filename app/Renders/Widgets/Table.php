<?php

namespace App\Renders\Widgets;

use App\Renders\Widgets\Table\Td;
use App\Renders\Widgets\Table\Th;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Table extends Widget implements Renderable
{

    /**
     * @var Collection
     */
    protected $headers = null;

    /**
     * @var Collection
     */
    protected $rows = null;


    /**
     * Table constructor.
     *
     * @param array $headers
     * @param array $rows
     * @param array $attributes
     */
    public function __construct($headers = [], $rows = [], $attributes = [])
    {
        $this->headers = collect();
        $this->rows = collect();
        $this->setHeaders($headers);
        $this->setRows($rows);
        parent::__construct($attributes);
    }

    protected function headers()
    {
        return $this->headers->map(function($header){
            if(is_array($header)){
                return (new Th($header['title'],$header['attributes']))->render();
            }else{
                return (new Th($header))->render();
            }
        })->implode('');
    }

    protected function rows()
    {
        return $this->rows->map(function($elements){
            $tdHtml = '<tr>';
            foreach ($elements as $element){
                $td = null;
                if(is_array($element)){
                    $td = new Td($element['title'], $element['attributes']);
                }else{
                    $td = new Td($element);
                }
                $tdHtml .= $td->render();
            }
            return $tdHtml.'</tr>';
        })->implode('');
    }

    protected function template(): string
    {
        return <<<TABLE
<table {$this->formatAttributes()}>
    <thead>
    <tr>
        {$this->headers()}
    </tr>
    </thead>
    <tbody>
    {$this->rows()}
    </tbody>
</table>
TABLE;

    }

    /**
     * Set table headers.
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders($headers = [])
    {
        $this->headers = collect($headers);

        return $this;
    }

    /**
     * Set table rows.
     *
     * @param array $rows
     *
     * @return $this
     */
    public function setRows($rows = [])
    {
        if (Arr::isAssoc($rows)) {
            foreach ($rows as $key => $item) {
                $this->rows->push([$key, $item]);
            }

            return $this;
        }

        $this->rows = collect($rows);

        return $this;
    }

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        return $this->template();
    }
}
