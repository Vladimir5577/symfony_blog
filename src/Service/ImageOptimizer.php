<?php

namespace App\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class ImageOptimizer
{
    private const THUMBNAIL_MAX_WIDTH = 200;
    private const THUMBNAIL_MAX_HEIGHT = 150;

    private const NORMAL_MAX_WIDTH = 600;
    private const NORMAL_MAX_HEIGHT = 550;

    private $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resize(string $uploadDir, string $filename): void
    {

        // dd($uploadDir, $filename);

        $thumbnail_dir = $uploadDir . '/thumbnail/';

        // dd($thumbnail_dir);

        if ( !file_exists( $thumbnail_dir ) && !is_dir( $thumbnail_dir ) ) {
            mkdir( $thumbnail_dir );       
        } 


        // resize to thumbnail
        list($iwidth, $iheight) = getimagesize($uploadDir . '/' . $filename);
        $ratio = $iwidth / $iheight;
        $width = self::THUMBNAIL_MAX_WIDTH;
        $height = self::THUMBNAIL_MAX_HEIGHT;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        $photo = $this->imagine->open($uploadDir . '/' . $filename);
        $photo->resize(new Box($width, $height))->save($thumbnail_dir . $filename);

        // resize a little bit
        list($iwidth, $iheight) = getimagesize($uploadDir . '/' . $filename);
        $ratio = $iwidth / $iheight;
        $width = self::NORMAL_MAX_WIDTH;
        $height = self::NORMAL_MAX_HEIGHT;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        $photo = $this->imagine->open($uploadDir . '/' . $filename);
        $photo->resize(new Box($width, $height))->save($uploadDir . '/' . $filename);
    }
}