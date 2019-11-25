<?php

class Delogo
{
    const VENDOR = 'deidee';
    const RED = '#ff0000';
    const WHITE = '#ffffff';

    private $c = []; // Collection of characters.
    private $im;
    private $cols;
    private $rows;
    private $height = 300;
    private $width = 300;
    private $size = 24;
    private $type = 'svg';
    private $text;

    public function __construct($str = self::VENDOR, $settings = [])
    {
        // Set the text.
        $this->setText($str);

        // This is where the magick happens.
        $this->im = new Imagick();
        $this->im->newImage($this->width, $this->height, new ImagickPixel(self::RED));
        $this->im->setImageFormat($this->type);
    }

    public function __toString()
    {
        return $this->text;
    }

    public function display()
    {
        header('Content-Type: ' . $this->im->getImageMimeType());

        echo $this->im->getImageBlob();
    }

    public function setText($str = '')
    {
        $this->text = $str;
    }
}
