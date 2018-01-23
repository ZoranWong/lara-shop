<?php
namespace App\Renders;

class JsLoader
{
    protected $jsContainer = null;

    protected static $instance = null;
    protected function __construct()
    {
        $this->jsContainer = collect();
    }

    public static function getInstance()
    {
        return static::$instance ? static::$instance : (static::$instance = new self());
    }

    public function js($js, string $loadedScript = null){
        $js = (array)$js;
        $this->jsContainer->push([$js, $loadedScript]);
    }

    public function render()
    {
        return view('components.partials.js-load-script')->with([
            'jsContainer' => $this->jsContainer
        ]);
    }

    public function __toString()
    {
        return $this->render()->render();
    }
}