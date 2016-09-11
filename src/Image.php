<?php namespace GDText;

class Image {
    /**
     * @var mixed
     */
    protected $resource;

    public function __construct($resource) {
        $this->resource = $resource;
    }

    public function getResource() {
        return $this->resource;
    }

    public function text($text, $x = 0, $y = 0, Font $font) {
        $font->draw($this, $text, $x, $y);
    }
}
