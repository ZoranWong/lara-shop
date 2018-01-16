<?php

namespace App\Renders\Layout;

use Illuminate\Contracts\Support\Renderable;

class Column extends \Encore\Admin\Layout\Column
{

    /**
     * @var int|array
     * */
    protected $width = null;
    /**
     * @var int
     * */
    protected $height = null;
    /**
     * Column constructor.
     *
     * @param $content
     * @param int $width
     */
    public function __construct($content, $width = 12)
    {
        parent::__construct($content, $width);
    }

    /**
     * Append content to column.
     *
     * @param $content
     *
     * @return $this
     */
    public function append($content)
    {
        $this->contents[] = $content;
logger('content', [class_basename($content)]);
        return $this;
    }

    /**
     * @param int $value
     * @return int
     * */
    public function height(int $value = null) : int
    {
        // TODO: Implement __set() method.
        if($value){
            return $this->height = $value;
        }else{
            return $this->height;
        }
    }

    /**
     * Add a row for column.
     *
     * @param $content
     *
     * @return Column
     */
    public function row($content)
    {
        if (!$content instanceof \Closure) {
            $row = new Row($content);
        } else {
            $row = new Row();

            call_user_func($content, $row);
        }

        ob_start();

        $row->build();

        $contents = ob_get_contents();

        ob_end_clean();

        return $this->append($contents);
    }

    /**
     * Build column html.
     */
    public function build()
    {
        $this->startColumn();
        foreach ($this->contents as $content) {
            if ($content instanceof Renderable) {
                echo $content->render();
            } else {
                echo (string) $content;
            }
        }

        $this->endColumn();
    }

    /**
     * Start column.
     */
    protected function startColumn()
    {
        $col = "";
        if(is_array($this->width)){
            foreach ($this->width as $key => $value){
                $col .= " col-".$key.'-'.$value;
            }
        }else{
            $col = $this->width  ? "col-md-{$this->width}" : "col";
        }

        echo "<div class=\"{$col}\">";
    }

    /**
     * End column.
     */
    protected function endColumn()
    {
        echo '</div>';
    }
}
