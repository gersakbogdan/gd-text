<?php
namespace GDText;

use GDText\ImageFromFile;
use GDText\Color;

class ImageCreator {
    public static function make($type) {

        if (is_string($type)) {
            if (is_file($type) || filter_var($type, FILTER_VALIDATE_URL)) {
                $resource = imagecreatefromstring(file_get_contents($type));
            }
        }

        if ($resource === FALSE) {
            throw new \Exception('Invalid image file resource');
        }

        return new Image($resource);
    }

    public static function canvas($width, $height, Color $color) {
        $resource = imagecreatetruecolor($width, $height);
        imagefill($resource, 0, 0, $color->getIndex($resource));

        return new Image($resource);
    }
}
