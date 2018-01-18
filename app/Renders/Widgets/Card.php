<?php
namespace App\Renders\Widgets;

use App\Renders\Facades\SectionContent;

class Card extends Widget
{
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        SectionContent::css((function(){
            return <<<CSS
                .small-box .icon {
                    top: -13px !important;
                }
CSS;
        })());
    }

    protected function template() : string
    {
        $bg_color = '';
        $num = '';
        $title = '';
        $icon = '';
        extract($this->attributes, EXTR_OVERWRITE);
        return <<<CARD
<div >
    <!-- small box -->
    <div class="small-box bg-{$bg_color}">
        <div class="inner">
            <h3>{$num}</h3>
            <p>{$title}</p>
        </div>
        <div class="icon">
            <i class="fa fa-{$icon}"></i>
        </div>
    </div>
</div>
CARD;
    }

    public function render()
    {
        // TODO: Implement render() method.

        return $this->template();
    }
}