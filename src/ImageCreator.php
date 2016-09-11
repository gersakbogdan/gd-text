<?php
namespace GDText;

use GDText\ImageCreatorInterface;
use GDText\ImageFromFile;

class ImageCreator implements ImageCreatorInterface {
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
}
