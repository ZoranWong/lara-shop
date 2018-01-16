<?php
namespace App\Renders;
//use Illuminate\Contracts\Support\Renderable;
use App\Exceptions\Handler;
use App\Renders\From\Builder;
use Illuminate\Support\Collection;
use App\Renders\From\Field;
/**
 * Class Form.
 *
 * @method Field\Text           text($column, $label = '')
 * @method Field\Checkbox       checkbox($column, $label = '')
 * @method Field\Radio          radio($column, $label = '')
 * @method Field\Select         select($column, $label = '')
 * @method Field\MultipleSelect multipleSelect($column, $label = '')
 * @method Field\Textarea       textarea($column, $label = '')
 * @method Field\Hidden         hidden($column, $label = '')
 * @method Field\Id             id($column, $label = '')
 * @method Field\Ip             ip($column, $label = '')
 * @method Field\Url            url($column, $label = '')
 * @method Field\Color          color($column, $label = '')
 * @method Field\Email          email($column, $label = '')
 * @method Field\Mobile         mobile($column, $label = '')
 * @method Field\Slider         slider($column, $label = '')
 * @method Field\Map            map($latitude, $longitude, $label = '')
 * @method Field\Editor         editor($column, $label = '')
 * @method Field\File           file($column, $label = '')
 * @method Field\Image          image($column, $label = '')
 * @method Field\Date           date($column, $label = '')
 * @method Field\Datetime       datetime($column, $label = '')
 * @method Field\Time           time($column, $label = '')
 * @method Field\Year           year($column, $label = '')
 * @method Field\Month          month($column, $label = '')
 * @method Field\DateRange      dateRange($start, $end, $label = '')
 * @method Field\DateTimeRange  datetimeRange($start, $end, $label = '')
 * @method Field\TimeRange      timeRange($start, $end, $label = '')
 * @method Field\Number         number($column, $label = '')
 * @method Field\Currency       currency($column, $label = '')
 * @method Field\HasMany        hasMany($relationName, $callback)
 * @method Field\SwitchField    switch($column, $label = '')
 * @method Field\Display        display($column, $label = '')
 * @method Field\Rate           rate($column, $label = '')
 * @method Field\Divide         divider()
 * @method Field\Password       password($column, $label = '')
 * @method Field\Decimal        decimal($column, $label = '')
 * @method Field\Html           html($html, $label = '')
 * @method Field\Tags           tags($column, $label = '')
 * @method Field\Icon           icon($column, $label = '')
 * @method Field\Embeds         embeds($column, $label = '')
 * @method Field\MultipleImage  multipleImage($column, $label = '')
 * @method Field\MultipleFile   multipleFile($column, $label = '')
 * @method Field\Captcha        captcha($column, $label = '')
 * @method Field\Listbox        listbox($column, $label = '')
 */
class Form extends \Encore\Admin\Form
{
    /**
     * Collected field assets.
     *
     * @var Collection
     */
    protected static $collectedAssets = [];


    /**
     * Field rows in form.
     *
     * @var array
     */
    public $rows = [];

    /**
     * Create a new form instance.
     *
     * @param $model
     * @param \Closure $callback
     */
    public function __construct($model, \Closure $callback)
    {
        $this->model = $model;

        $this->builder = new Builder($this);

        $callback($this);
    }

    /**
     * Collect assets required by registered field.
     *
     * @return Collection
     */
    public static function collectFieldAssets() : Collection
    {
        if (!empty(static::$collectedAssets)) {
            return static::$collectedAssets;
        }
        $css = collect();
        $js = collect();
        $link =collect();
        $fields = collect(static::$availableFields);
        $fields->map(function ($field ) use (&$js, &$css, &$link) {
            if (method_exists($field, 'getAssets')) {
                $assets = call_user_func([$field, 'getAssets']);
                $css->push(array_get($assets, 'css'));
                $js->push(array_get($assets, 'js'));
                $link->push(array_get($assets, 'link'));
            }
        });

        return static::$collectedAssets = collect([
            'css' => $css->flatten()->unique()->filter()->toArray(),
            'js'  => $js->flatten()->unique()->filter()->toArray(),
            'link' =>$link->flatten()->unique()->filter()->toArray()
        ]);
    }

    /**
     * Get current resource route url.
     *
     * @param int $slice
     *
     * @return string
     */
    public function resource($slice = -2)
    {
        $segments = explode('/', trim(app('request')->getUri(), '/'));

        if ($slice != 0) {
            $segments = array_slice($segments, 0, $slice);
        }

        return implode('/', $segments);
    }

    /**
     * Generate a Field object and add to form builder if Field exists.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return Field|void
     */
    public function __call($method, $arguments)
    {
        if ($className = static::findFieldClass($method)) {
            $column = array_get($arguments, 0, ''); //[0];

            $element = new $className($column, array_slice($arguments, 1));

            $this->pushField($element);

            return $element;
        }
    }

    /**
     * Register builtin fields.
     *
     * @return void
     */
    public static function registerBuiltinFields()
    {
        $map = [
            'button'         => Field\Button::class,
            'checkbox'       => Field\Checkbox::class,
            'color'          => Field\Color::class,
            'currency'       => Field\Currency::class,
            'date'           => Field\Date::class,
            'dateRange'      => Field\DateRange::class,
            'datetime'       => Field\Datetime::class,
            'dateTimeRange'  => Field\DatetimeRange::class,
            'datetimeRange'  => Field\DatetimeRange::class,
            'decimal'        => Field\Decimal::class,
            'display'        => Field\Display::class,
            'divider'        => Field\Divide::class,
            'divide'         => Field\Divide::class,
            'embeds'         => Field\Embeds::class,
            'editor'         => Field\Editor::class,
            'email'          => Field\Email::class,
            'file'           => Field\File::class,
            'hasMany'        => Field\HasMany::class,
            'hidden'         => Field\Hidden::class,
            'id'             => Field\Id::class,
            'image'          => Field\Image::class,
            'ip'             => Field\Ip::class,
            'map'            => Field\Map::class,
            'mobile'         => Field\Mobile::class,
            'month'          => Field\Month::class,
            'multipleSelect' => Field\MultipleSelect::class,
            'number'         => Field\Number::class,
            'password'       => Field\Password::class,
            'radio'          => Field\Radio::class,
            'rate'           => Field\Rate::class,
            'select'         => Field\Select::class,
            'slider'         => Field\Slider::class,
            'switch'         => Field\SwitchField::class,
            'text'           => Field\Text::class,
            'textarea'       => Field\Textarea::class,
            'time'           => Field\Time::class,
            'timeRange'      => Field\TimeRange::class,
            'url'            => Field\Url::class,
            'year'           => Field\Year::class,
            'html'           => Field\Html::class,
            'tags'           => Field\Tags::class,
            'icon'           => Field\Icon::class,
            'multipleFile'   => Field\MultipleFile::class,
            'multipleImage'  => Field\MultipleImage::class,
            'captcha'        => Field\Captcha::class,
            'listbox'        => Field\Listbox::class,
        ];

        foreach ($map as $abstract => $class) {
            static::extend($abstract, $class);
        }
    }

    public function render()
    {
        try {
            return $this->builder->render();
        } catch (\Exception $e) {
            return Handler::renderException($e);
        }
    }
}