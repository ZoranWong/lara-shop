<?php
namespace App\Renders\Widgets\Table;

use App\Renders\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;

class Td extends Widget
{   protected $content = '';
    public function __construct($content, array $attributes = [])
    {
        $this->content = $content instanceof Renderable ? $content->render() : $content;
        parent::__construct( $attributes);
    }

    public function render()
    {
        // TODO: Implement render() method.
        return <<<HTML
                <td {$this->formatAttributes()}>{$this->content}</td>
HTML;
    }
}