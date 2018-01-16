<?php
namespace App\Renders\Widgets\Table;
use App\Renders\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;

class Th extends Widget
{
    protected $title = '';
    public function __construct($title, array $attributes = [])
    {
        $this->title = $title instanceof Renderable ? $title->render() : $title;
        parent::__construct( $attributes);
    }

    public function render()
    {
        // TODO: Implement render() method.
        return <<<HTML
                <th {$this->formatAttributes()}>{$this->title}</th>
HTML;

    }
}