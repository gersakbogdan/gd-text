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
}
