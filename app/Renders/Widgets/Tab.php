<?php

namespace App\Renders\Widgets;

use App\Renders\Facades\SectionContent;
use Illuminate\Contracts\Support\Renderable;

class Tab extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'components.widgets.tab';

    /**
     * @var array
     */
    protected $data = [
        'id'       => '',
        'title'    => '',
        'tabs'     => [],
        'dropDown' => [],
        'active'   => 0,
    ];

    public function __construct()
    {
        $this->class('nav-tabs-custom');
    }


    public function template(): string
    {
        return <<<TEMPLATE
       <ul class="nav nav-tabs">
            <li class="active"><a href="#selling" data-toggle="tab" aria-expanded="true">出售中</a></li>
            <li class=""><a href="#saleout" data-toggle="tab" aria-expanded="false">已售罄</a></li>
            <li class=""><a href="#stock" data-toggle="tab" aria-expanded="false">仓库中</a></li>
        </ul>
TEMPLATE;
    }

    /**
     * Add a tab and its contents.
     *
     * @param string            $title
     * @param string|Renderable $content
     *
     * @return $this
     */
    public function add($title, $content, $active = false)
    {
        $this->data['tabs'][] = [
            'id'      => mt_rand(),
            'title'   => $title,
            'content' => $content,
        ];

        if ($active) {
            $this->data['active'] = count($this->data['tabs']) - 1;
        }

        return $this;
    }

    /**
     * Set title.
     *
     * @param string $title
     */
    public function title($title = '')
    {
        $this->data['title'] = $title;
    }

    /**
     * Set drop-down items.
     *
     * @param array $links
     *
     * @return $this
     */
    public function dropDown(array $links)
    {
        if (is_array($links[0])) {
            foreach ($links as $link) {
                call_user_func([$this, 'dropDown'], $link);
            }

            return $this;
        }

        $this->data['dropDown'][] = [
            'name' => $links[0],
            'href' => $links[1],
        ];

        return $this;
    }

    protected function script()
    {
        return <<<SCRIPT
$(".nav-item").on('click', function(event){
    $('.nav-item').each(function(index, item){
        navItem = $(item);
        if(navItem.hasClass('active')){
            navItem.removeClass('active');
        }
    });
    $(this).addClass('active');
});
SCRIPT;

    }

    /**
     * Render Tab.
     *
     * @return string
     */
    public function render()
    {
        $variables = array_merge($this->data, ['attributes' => $this->formatAttributes()]);
        SectionContent::script($this->script());
        return view($this->view, $variables)->render();
    }
}
