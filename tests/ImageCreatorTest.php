<?php
namespace GDText\Tests;

use GDText\ImageCreator;

class ImageCreatorTest extends TestCase
{
    public function testInitFromPath() {
        $image = ImageCreator::make(__DIR__ . '/images/owl_png24.png');
        imagealphablending($image->getResource(), true);
        imagesavealpha($image->getResource(), true);

        $this->assertImageEquals('test_creator.png', $image->getResource());
    }
}
