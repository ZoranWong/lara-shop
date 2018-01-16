<?php

namespace App\Renders\From\Field;

use App\Renders\From;

class Captcha extends \Encore\Admin\Form\Field\Captcha
{
    protected $rules = 'required|captcha';

    protected $view = 'components.form.captcha';
}
