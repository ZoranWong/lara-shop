<?php

namespace App\Renders\From\Field;

class Icon extends Text
{
    protected $default = 'fa-pencil';

    protected static $link = [
        '/vendor/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css',
    ];

    protected static $js = [
        '/vendor/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.js',
    ];

    public function render()
    {
        $this->script = <<<EOT

$('{$this->getElementClassSelector()}').iconpicker({
    placement:'bottomLeft'
});

EOT;

        $this->prepend('<i class="fa fa-pencil"></i>')
            ->defaultAttribute('style', 'width: 140px');

        return parent::render();
    }
}
