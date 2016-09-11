<?php
namespace GDText\Tests;

use GDText\Box;
use GDText\Font;
use GDText\Color;
use GDText\TextWrapping;

class TextWrappingTest extends TestCase
{
    protected function mockBox($im)
    {
        imagealphablending($im, true);
        imagesavealpha($im, true);

        $font = new Font(__DIR__.'/LinLibertine_R.ttf'); // http://www.dafont.com/franchise.font
        $font->setColor(new Color(255, 75, 140))
             ->setSize(16);

        $box = new Box($im, $font);
        $box->setBox(0, 135, imagesx($im), 70);
        $box->setTextAlign('left', 'top');
        return $box;
    }

    public function testWrapWithOverflow()
    {
        $im = $this->openImageResource('owl_png24.png');
        $box = $this->mockBox($im);
        $box->setTextWrapping(TextWrapping::WrapWithOverflow);
        $box->draw("Owls are birds from the order Strigiformes, which includes about 200 species.");

        $this->assertImageEquals('test_wrap_WrapWithOverflow.png', $im);
    }

    public function testNoWrap()
    {
        $im = $this->openImageResource('owl_png24.png');
        $box = $this->mockBox($im);
        $box->setTextWrapping(TextWrapping::NoWrap);
        $box->draw("Owls are birds from the order Strigiformes, which includes about 200 species.");

        $this->assertImageEquals('test_wrap_NoWrap.png', $im);
    }
}
