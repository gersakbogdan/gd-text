<?php namespace GDText;

use GDText\Color;

class Font {
    /**
     * @var int
     */
    protected $size = 12;

    /**
     * @var Color
     */
    protected $color;

    /**
     * @var float
     */
    protected $angle = 0.0;

    /**
     * @var string
     */
    protected $file;

    /**
     * @var int
     */
    protected $strokeSize = 0;

    /**
     * @var Color
     */
    protected $strokeColor;

    /**
     * @var bool|array
     */
    protected $shadow = false;

    /**
     * @var float
     */
    protected $lineHeight = 1.25;

    public function __construct($file) {
        $this->setFile($file);

        $color = new Color(0, 0, 0);
        $this->color = $color;
        $this->strokeColor = $color;
    }

    /**
     * @param int $size Font size in *pixels*
     */
    public function setSize($size) {
        $this->size = $size;

        return $this;
    }

    public function getSize() {
        return $this->size;
    }

    /**
     * @param Color $color Font color
     */
    public function setColor(Color $color) {
        $this->color = $color;

        return $this;
    }

    public function getColor() {
        return $this->color;
    }

    /**
     * @param string $path Path to the font file
     */
    public function setFile($path) {
        if (!is_string($path) || !file_exists($path)) {
            throw new \InvalidArgumentException('Invalid Font File Path!');
        }

        $this->file = $path;

        return $this;
    }

    public function getFile() {
        return $this->file;
    }

    /**
     * @param Color $color Stroke color
     */
    public function setStrokeColor(Color $color) {
        $this->strokeColor = $color;

        return $this;
    }

    public function getStrokeColor() {
        return $this->strokeColor;
    }

    /**
     * @param int $v Stroke size in *pixels*
     */
    public function setStrokeSize($v) {
        $this->strokeSize = $v;

        return $this;
    }

    public function getStrokeSize() {
        return $this->strokeSize;

        return $this;
    }

    /**
     * @param Color $color Shadow color
     * @param int $xShift Relative shadow position in pixels. Positive values move shadow to right, negative to left.
     * @param int $yShift Relative shadow position in pixels. Positive values move shadow to bottom, negative to up.
     */
    public function setShadow(Color $color, $xShift, $yShift) {
        $this->shadow = ['color' => $color, 'x' => $xShift, 'y' => $yShift];

        return $this;
    }

    public function getShadow() {
        return $this->shadow;
    }

    /**
     * @param float $v The angle in degrees. 0 being left-to-righ reading text
     */
    public function setAngle($v) {
        $this->angle = (float) $v;

        return $this;
    }

    public function getAngle() {
        return $this->angle;
    }

    /**
     * Allows to customize spacing between lines.
     * @param float $v Height of the single text line, in percents, proportionally to font size
     */
    public function setLineHeight($lineHeight) {
        $this->lineHeight = $lineHeight;

        return $this;
    }

    public function getLineHeight() {
        return $this->lineHeight;
    }
    /**
     * @return float
     */
    public function getSizeInPoints() {
        return 0.75 * $this->size;
    }
}
