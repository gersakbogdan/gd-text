<?php
namespace GDText\Tests;

use GDText\ImageCreator;
use GDText\Color;

class ImageCreatorTest extends TestCase
{
    public function testMake() {
        $image = ImageCreator::make(__DIR__ . '/images/owl_png24.png');
        imagealphablending($image->getResource(), true);
        imagesavealpha($image->getResource(), true);

        $this->assertImageEquals('test_creator.png', $image->getResource());
    }

    public function testCanvas() {
        $image = ImageCreator::canvas(1, 1, new Color(0, 0, 0));
        $this->assertEquals(
            $this->sha1ImageGD(imagecreatetruecolor(1, 1)),
            $this->sha1ImageGD($image->getResource())
        );
    }
}
