<?php
namespace App\Renders\Layout;

class Js implements Buildable
{
    protected $isLink = false;

    protected $js = null;

    public function __construct(string $js, bool $isLink)
    {
        $this->isLink = $isLink;
        $this->js = $js;
    }

    public function href()
    {
        return assert($this->js);
    }

    protected function id()
    {
        return str_random();
    }

    /**
     * Build row column.
     */
    public function build()
    {
        if($this->isLink())
        return <<<JS
            <script  href="{$this->href()}"></script>
JS;
        return <<<JS
        {$this->startJs()}
            {$this->js}
        {$this->endJs()}
JS;
    }

    /**
     * Start row.
     */
    protected function startJs()
    {
        return <<<START
<script type="text/javascript" id="{$this->id()}">
START;
    }

    /**
     * End column.
     */
    protected function endJs()
    {
        return <<<END
</script>
END;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->build();
    }
}