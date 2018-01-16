<?php

namespace App\Renders\From\Field;

class Time extends Date
{
    protected $format = 'HH:mm:ss';

    public function render()
    {
        $this->prepend('<i class="fa fa-clock-o"></i>')
            ->defaultAttribute('style', 'width: 150px');

        return parent::render();
    }
}
