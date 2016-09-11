<?php
namespace GDText;

interface ImageCreatorInterface {
    public static function make($type);
    public static function canvas($width, $height, Color $color);
}
