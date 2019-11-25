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
    private $type = 'png';
    private $text;
    public $ones = 0;
    public $zeroes = 0;

    public function __construct($str = self::VENDOR, $settings = [])
    {
        $this->c[0x64] = array(0,0,1,0,0,1,1,1,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//d
        $this->c[0x65] = array(0,0,0,0,0,0,1,1,1,1,0,1,1,1,1,1,0,0,1,1,1,0,0,0,0,0,0);//e

        $this->c[0x69] = array(1,0,1,1,1,1,1,0,0);//i

        // Set the text.
        $this->setText($str);
        // Get the length of the text (multi byte save).
        $length = mb_strlen($this->text);

        // This is where the magick happens.
        $this->im = new Imagick();
        $this->im->newImage($this->width, $this->height, new ImagickPixel(self::RED));
        $this->im->setImageFormat($this->type);

        $draw = new ImagickDraw();
        $draw->setViewbox(0, 0, $this->width, $this->height);
        $draw->setStrokeWidth(0);

        $this->im->drawImage($draw);

        for($i = 0; $i < $length; ++$i)
        {
            $char = mb_substr($this->text, $i, 1);

            if(isset($this->c[mb_ord($char)])) $this->ones += array_sum($this->c[mb_ord($char)]);
        }
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
