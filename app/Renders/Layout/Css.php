<?php
namespace App\Renders\Layout;

class Css implements Buildable
{
    protected $isLink = false;

    protected $css = null;

    public function __construct(string $css, bool $isLink)
    {
        $this->isLink = $isLink;
        $this->css = $css;
    }

    public function isLink() : bool
    {
        return $this->isLink;
    }

    public function href()
    {
        return assert($this->css);
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
        return <<<LINK
<link rel="stylesheet" href="{$this->href()}">
LINK;
        return <<<CSS
        {$this->startCss()}
            {$this->css}
        {$this->endCss()}
CSS;
    }

    /**
     * Start row.
     */
    protected function startCss()
    {
        return <<<START
<style type="text/css" class = "css-component" id="{$this->id()}">
START;
    }

    /**
     * End column.
     */
    protected function endCss()
    {
        return <<<END
</style>
END;

    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->build();
    }
}