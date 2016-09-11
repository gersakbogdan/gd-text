<?php
namespace GDText;

class Box
{
    /**
     * @var resource
     */
    protected $im;

    /**
     * @var Font
     */
    protected $font;

    /**
     * @var string
     */
    protected $alignX = 'left';

    /**
     * @var string
     */
    protected $alignY = 'top';

    /**
     * @var int
     */
    protected $textWrapping = TextWrapping::WrapWithOverflow;

    /**
     * @var float
     */
    protected $lineHeight = 1.25;

    /**
     * @var float
     */
    protected $baseline = 0.2;

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var bool|Color
     */
    protected $backgroundColor = false;

    /**
     * @var array
     */
    protected $box = array(
        'x' => 0,
        'y' => 0,
        'width' => 100,
        'height' => 100
    );

    public function __construct(&$image, $font)
    {
        $this->im = $image;
        $this->font = $font;
    }

    /**
     * @param Color $color Font color
     */
    public function setBackgroundColor(Color $color)
    {
        $this->backgroundColor = $color;
    }

    /**
     * Allows to customize spacing between lines.
     * @param float $v Height of the single text line, in percents, proportionally to font size
     */
    public function setLineHeight($v)
    {
        $this->lineHeight = $v;
    }

    /**
     * @param float $v Position of baseline, in percents, proportionally to line height measuring from the bottom.
     */
    public function setBaseline($v)
    {
        $this->baseline = $v;
    }

    /**
     * Sets textbox position and dimensions
     * @param int $x Distance in pixels from left edge of image.
     * @param int $y Distance in pixels from top edge of image.
     * @param int $width Width of texbox in pixels.
     * @param int $height Height of textbox in pixels.
     */
    public function setBox($x, $y, $width, $height)
    {
        $this->box['x'] = $x;
        $this->box['y'] = $y;
        $this->box['width'] = $width;
        $this->box['height'] = $height;
    }

    /**
     * Enables debug mode. Whole textbox and individual lines will be filled with random colors.
     */
    public function enableDebug()
    {
        $this->debug = true;
    }

    /**
     * @param int $textWrapping
     */
    public function setTextWrapping($textWrapping)
    {
        $this->textWrapping = $textWrapping;
    }

    /**
     * Sets text alignment inside textbox
     * @param string $x Horizontal alignment. Allowed values are: left, center, right.
     * @param string $y Vertical alignment. Allowed values are: top, center, bottom.
     */
    public function setTextAlign($x = 'left', $y = 'top')
    {
        $xAllowed = array('left', 'right', 'center');
        $yAllowed = array('top', 'bottom', 'center');

        if (!in_array($x, $xAllowed)) {
            throw new \InvalidArgumentException('Invalid horizontal alignement value was specified.');
        }

        if (!in_array($y, $yAllowed)) {
            throw new \InvalidArgumentException('Invalid vertical alignement value was specified.');
        }

        $this->alignX = $x;
        $this->alignY = $y;
    }

    /**
     * Draws the text on the picture.
     * @param string $text Text to draw. May contain newline characters.
     */
    public function draw($text)
    {
        switch ($this->textWrapping) {
            case TextWrapping::NoWrap:
                $lines = array($text);
                break;
            case TextWrapping::WrapWithOverflow:
            default:
                $lines = $this->wrapTextWithOverflow($text);
                break;
        }

        if ($this->debug) {
            // Marks whole texbox area with color
            $this->drawFilledRectangle(
                $this->box['x'],
                $this->box['y'],
                $this->box['width'],
                $this->box['height'],
                new Color(rand(180, 255), rand(180, 255), rand(180, 255), 80)
            );
        }

        $lineHeightPx = $this->lineHeight * $this->font->getSize();
        $textHeight = count($lines) * $lineHeightPx;

        switch ($this->alignY) {
            case VerticalAlignment::Center:
                $yAlign = ($this->box['height'] / 2) - ($textHeight / 2);
                break;
            case VerticalAlignment::Bottom:
                $yAlign = $this->box['height'] - $textHeight;
                break;
            case VerticalAlignment::Top:
            default:
                $yAlign = 0;
        }

        $n = 0;
        foreach ($lines as $line) {
            $box = $this->calculateBox($line);
            $boxWidth = $box[2] - $box[0];
            switch ($this->alignX) {
                case HorizontalAlignment::Center:
                    $xAlign = ($this->box['width'] - $boxWidth) / 2;
                    break;
                case HorizontalAlignment::Right:
                    $xAlign = ($this->box['width'] - $boxWidth);
                    break;
                case HorizontalAlignment::Left:
                default:
                    $xAlign = 0;
            }
            $yShift = $lineHeightPx * (1 - $this->baseline);

            // current line X and Y position
            $xMOD = $this->box['x'] + $xAlign;
            $yMOD = $this->box['y'] + $yAlign + $yShift + ($n * $lineHeightPx);

            if ($line && $this->backgroundColor) {
                // Marks whole texbox area with given background-color
                $backgroundHeight = $this->fontSize;

                $this->drawFilledRectangle(
                    $xMOD,
                    $this->box['y'] + $yAlign + ($n * $lineHeightPx) + ($lineHeightPx - $backgroundHeight) + (1 - $this->lineHeight) * 13 * (1 / 50 * $this->fontSize),
                    $boxWidth,
                    $backgroundHeight,
                    $this->backgroundColor
                );
            }

            if ($this->debug) {
                // Marks current line with color
                $this->drawFilledRectangle(
                    $xMOD,
                    $this->box['y'] + $yAlign + ($n * $lineHeightPx),
                    $boxWidth,
                    $lineHeightPx,
                    new Color(rand(1, 180), rand(1, 180), rand(1, 180))
                );
            }

            if (is_array($this->font->getShadow())) {
                $this->drawInternal(
                    $xMOD + $this->font->getShadow()['x'],
                    $yMOD + $this->font->getShadow()['y'],
                    $this->font->getShadow()['color'],
                    $line
                );

            }

            $this->strokeText($xMOD, $yMOD, $line);
            $this->drawInternal(
                $xMOD,
                $yMOD,
                $this->font->getColor(),
                $line
            );

            $n++;
        }
    }

    /**
     * Splits overflowing text into array of strings.
     * @param string $text
     * @return string[]
     */
    protected function wrapTextWithOverflow($text)
    {
        $lines = array();
        // Split text explicitly into lines by \n, \r\n and \r
        $explicitLines = preg_split('/\n|\r\n?/', $text);
        foreach ($explicitLines as $line) {
            // Check every line if it needs to be wrapped
            $words = explode(" ", $line);
            $line = $words[0];
            for ($i = 1; $i < count($words); $i++) {
                $box = $this->calculateBox($line." ".$words[$i]);
                if (($box[4]-$box[6]) >= $this->box['width']) {
                    $lines[] = $line;
                    $line = $words[$i];
                } else {
                    $line .= " ".$words[$i];
                }
            }
            $lines[] = $line;
        }
        return $lines;
    }

    protected function drawFilledRectangle($x, $y, $width, $height, Color $color)
    {
        $points = [
            [$x, $y], [$x, $y+$height],
            [$x+$width, $y+$height], [$x+$width, $y]
        ];
        $angle = deg2rad(-$this->font->getAngle());

        foreach ($points as &$p) {
            $p0 = $p[0];
            $p1 = $p[1];
            $p[0] = $x + ($p0-$x)*cos($angle) - ($p1-$y)*sin($angle);
            $p[1] = $y + ($p0-$x)*sin($angle) + ($p1-$y)*cos($angle);
        }

        imagefilledpolygon($this->im, call_user_func_array('array_merge', $points),
            4, $color->getIndex($this->im)
        );
    }

    protected function calculateBox($text)
    {
        return imageftbbox($this->font->getSizeInPoints(), 0, $this->font->getFile(), $text);
    }

    protected function strokeText($x, $y, $text)
    {
        $size = $this->font->getStrokeSize();
        if ($size <= 0) return;
        for ($c1 = $x - $size; $c1 <= $x + $size; $c1++) {
            for ($c2 = $y - $size; $c2 <= $y + $size; $c2++) {
                $this->drawInternal($c1, $c2, $this->strokeColor, $text);
            }
        }
    }

    protected function drawInternal($x, $y, Color $color, $text)
    {
        imagefttext(
            $this->im,
            $this->font->getSizeInPoints(),
            $this->font->getAngle(),
            $x,
            $y,
            $color->getIndex($this->im),
            $this->font->getFile(),
            $text
        );
    }
}
