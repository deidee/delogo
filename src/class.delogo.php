<?php

class Delogo
{
    const HEIGHT_MULTIPLIER = 11;
    const ROWS = 9;
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
    public $zeros = 0;
    public $x = 0;
    public $y = 0;

    public function __construct($str = self::VENDOR, $settings = [])
    {
        // All characters data taken from old deidee libraries.
        $this->c[0x20] = array();//[SPACE]
        $this->c[0x21] = array(1,1,1,1,1,0,1,0,0);//!

        $this->c[0x27] = array(1,1,0,0,0,0,0,0,0);//'

        $this->c[0x2b] = array(0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,1,1,1,0,1,0,0,0,0,0,0,0);//+
        $this->c[0x2c] = array(0,0,0,0,0,0,1,1,0);//,
        $this->c[0x2d] = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,0,0,0,0,0,0,0,0,0);//-

        $this->c[0x2e] = array(0,0,0,0,0,0,1,0,0);//.

        $this->c[0x30] = array(1,1,1,1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//0
        $this->c[0x31] = array(0,1,0,1,1,0,0,1,0,0,1,0,0,1,0,0,1,0,1,1,1,0,0,0,0,0,0);//1
        $this->c[0x32] = array(1,1,1,0,0,1,0,0,1,1,1,1,1,0,0,1,0,0,1,1,1,0,0,0,0,0,0);//2
        $this->c[0x33] = array(1,1,1,0,0,1,0,0,1,1,1,1,0,0,1,0,0,1,1,1,1,0,0,0,0,0,0);//3
        $this->c[0x34] = array(1,0,1,1,0,1,1,0,1,1,1,1,0,0,1,0,0,1,0,0,1,0,0,0,0,0,0);//4
        $this->c[0x35] = array(1,1,1,1,0,0,1,0,0,1,1,1,0,0,1,0,0,1,1,1,1,0,0,0,0,0,0);//5
        $this->c[0x36] = array(1,0,0,1,0,0,1,0,0,1,1,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//6
        $this->c[0x37] = array(1,1,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,0,0,0,0);//7
        $this->c[0x38] = array(1,1,1,1,0,1,1,0,1,1,1,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//8
        $this->c[0x39] = array(1,1,1,1,0,1,1,0,1,1,1,1,0,0,1,0,0,1,0,0,1,0,0,0,0,0,0);//9
        $this->c[0x3A] = array(0,0,1,0,0,0,1,0,0);//:
        $this->c[0x3B] = array(0,0,1,0,0,0,1,1,0);//;
        $this->c[0x3C] = array(0,0,0,0,0,0,0,0,1,0,1,0,1,0,0,0,1,0,0,0,1,0,0,0,0,0,0);//<
        $this->c[0x3D] = array(0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,0,0,0,1,1,1,0,0,0,0,0,0);//=
        $this->c[0x3E] = array(0,0,0,0,0,0,1,0,0,0,1,0,0,0,1,0,1,0,1,0,0,0,0,0,0,0,0);//>
        $this->c[0x3F] = array(1,1,1,0,0,1,0,0,1,0,1,1,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0);//?

        $this->c[0x40] = array(
            1,1,1,1,1,1,1,
            0,0,0,0,0,0,1,
            1,1,1,1,1,0,1,
            1,0,0,0,1,0,1,
            1,0,1,1,1,0,1,
            1,0,1,0,1,0,1,
            1,0,1,1,1,0,1,
            1,0,0,0,0,0,1,
            1,1,1,1,1,1,1
        );//@

        $this->c[0x41] = array(1,1,1,1,0,1,1,0,1,1,1,1,1,0,1,1,0,1,1,0,1,0,0,0,0,0,0);//A
        $this->c[0x42] = array(1,1,0,1,0,1,1,0,1,1,1,0,1,0,1,1,0,1,1,1,0,0,0,0,0,0,0);//B
        $this->c[0x43] = array(1,1,1,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,1,1,0,0,0,0,0,0);//C
        $this->c[0x44] = array(1,1,0,1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,1,1,0,0,0,0,0,0,0);//D
        $this->c[0x45] = array(1,1,1,1,0,0,1,0,0,1,1,1,1,0,0,1,0,0,1,1,1,0,0,0,0,0,0);//E
        $this->c[0x46] = array(1,1,1,1,0,0,1,0,0,1,1,1,1,0,0,1,0,0,1,0,0,0,0,0,0,0,0);//F
        $this->c[0x47] = array(1,1,1,1,0,0,1,0,0,1,0,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//G
        $this->c[0x48] = array(1,0,1,1,0,1,1,0,1,1,1,1,1,0,1,1,0,1,1,0,1,0,0,0,0,0,0);//H
        $this->c[0x49] = array(1,1,1,0,1,0,0,1,0,0,1,0,0,1,0,0,1,0,1,1,1,0,0,0,0,0,0);//I
        $this->c[0x4A] = array(1,1,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,1,1,0,0,0,0,0,0,0);//J
        $this->c[0x4B] = array(1,0,1,1,0,1,1,0,1,1,1,0,1,0,1,1,0,1,1,0,1,0,0,0,0,0,0);//K
        $this->c[0x4C] = array(1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,1,1,0,0,0,0,0,0);//L
        $this->c[0x4D] = array(1,1,1,1,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0);//M
        $this->c[0x4E] = array(1,1,1,1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,0,0,0,0,0,0);//N
        $this->c[0x4F] = array(1,1,1,1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//O
        $this->c[0x50] = array(1,1,1,1,0,1,1,0,1,1,1,1,1,0,0,1,0,0,1,0,0,0,0,0,0,0,0);//P
        $this->c[0x51] = array(1,1,1,1,0,1,1,0,1,1,1,1,0,0,1,0,0,1,0,0,1,0,0,0,0,0,0);//Q
        $this->c[0x52] = array(1,1,1,1,0,1,1,0,1,1,1,0,1,0,1,1,0,1,1,0,1,0,0,0,0,0,0);//R
        $this->c[0x53] = array(1,1,1,1,0,0,1,0,0,1,1,1,0,0,1,0,0,1,1,1,1,0,0,0,0,0,0);//S
        $this->c[0x54] = array(1,1,1,0,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,0,0,0,0,0);//T
        $this->c[0x55] = array(1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//U
        $this->c[0x56] = array(1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,0,1,0,0,1,0,0,0,0,0,0,0);//V
        $this->c[0x57] = array(1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0);//W
        $this->c[0x58] = array(1,0,1,1,0,1,1,0,1,0,1,0,1,0,1,1,0,1,1,0,1,0,0,0,0,0,0);//X
        $this->c[0x59] = array(1,0,1,1,0,1,1,0,1,1,1,1,0,1,0,0,1,0,0,1,0,0,0,0,0,0,0);//Y
        $this->c[0x5A] = array(1,1,1,0,0,1,0,0,1,1,1,1,1,0,0,1,0,0,1,1,1,0,0,0,0,0,0);//Z

        $this->c[0x5F] = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,0,0,0,0,0,0);//_

        $this->c[0x61] = array(2,2,2,0,0,0,1,1,1,0,0,1,1,1,1,1,0,1,1,1,1,0,0,0,0,0,0);//a
        $this->c[0x62] = array(1,0,0,1,0,0,1,1,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//b
        $this->c[0x63] = array(0,0,0,0,0,0,1,1,1,1,0,0,1,0,0,1,0,0,1,1,1,0,0,0,0,0,0);//c
        $this->c[0x64] = array(0,0,1,0,0,1,1,1,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//d
        $this->c[0x65] = array(0,0,0,0,0,0,1,1,1,1,0,1,1,1,1,1,0,0,1,1,1,0,0,0,0,0,0);//e
        $this->c[0x66] = array(0,1,1,0,1,0,1,1,1,0,1,0,0,1,0,0,1,0,0,1,0,0,0,0,0,0,0);//f
        $this->c[0x67] = array(0,0,0,0,0,0,1,1,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,1,1,1,1);//g
        $this->c[0x68] = array(1,0,0,1,0,0,1,1,1,1,0,1,1,0,1,1,0,1,1,0,1,0,0,0,0,0,0);//h
        $this->c[0x69] = array(1,0,1,1,1,1,1,0,0);//i
        $this->c[0x6A] = array(1,0,1,1,1,1,1,1,1);//j
        $this->c[0x6B] = array(1,0,0,1,0,0,1,0,1,1,0,1,1,1,0,1,0,1,1,0,1,0,0,0,0,0,0);//k
        $this->c[0x6C] = array(1,1,1,1,1,1,1,0,0);//l
        $this->c[0x6D] = array(0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0);//m
        $this->c[0x6E] = array(0,0,0,0,0,0,1,1,1,1,0,1,1,0,1,1,0,1,1,0,1,0,0,0,0,0,0);//n
        $this->c[0x6F] = array(0,0,0,0,0,0,1,1,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//o
        $this->c[0x70] = array(0,0,0,0,0,0,1,1,1,1,0,1,1,0,1,1,0,1,1,1,1,1,0,0,1,0,0);//p
        $this->c[0x71] = array(0,0,0,0,0,0,1,1,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,1,0,0,1);//q
        $this->c[0x72] = array(0,0,0,0,0,0,1,1,1,1,0,0,1,0,0,1,0,0,1,0,0,0,0,0,0,0,0);//r
        $this->c[0x73] = array(0,0,0,0,0,0,1,1,1,1,0,0,1,1,1,0,0,1,1,1,1,0,0,0,0,0,0);//s
        $this->c[0x74] = array(0,0,0,0,1,0,1,1,1,0,1,0,0,1,0,0,1,0,0,1,0,0,0,0,0,0,0);//t
        $this->c[0x75] = array(0,0,0,0,0,0,1,0,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,0,0,0,0);//u
        $this->c[0x76] = array(0,0,0,0,0,0,1,0,1,1,0,1,1,0,1,1,0,1,0,1,0,0,0,0,0,0,0);//v
        $this->c[0x77] = array(0,0,0,0,0,0,0,0,0,0,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,0,1,0,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0);//w
        $this->c[0x78] = array(0,0,0,0,0,0,1,0,1,1,0,1,0,1,0,1,0,1,1,0,1,0,0,0,0,0,0);//x
        $this->c[0x79] = array(0,0,0,0,0,0,1,0,1,1,0,1,1,0,1,1,0,1,1,1,1,0,0,1,0,0,1);//y
        $this->c[0x7A] = array(0,0,0,0,0,0,1,1,1,0,0,1,1,1,1,1,0,0,1,1,1,0,0,0,0,0,0);//z

        $this->c[0xA9] = array(
            0,0,0,0,0,0,
            1,1,1,1,1,1,
            1,0,0,0,0,1,
            1,0,1,1,0,1,
            1,0,1,0,0,1,
            1,0,1,1,0,1,
            1,0,0,0,0,1,
            1,1,1,1,1,1,
            0,0,0,0,0,0
        );//©

        $this->c[0x2019] = array(1,1,0,0,0,0,0,0,0);//’ // TODO: Make slanted.

        $this->c[0x2709] = array(
            0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,
            1,1,1,1,1,1,1,
            1,1,0,0,0,1,1,
            1,0,1,0,1,0,1,
            1,0,0,1,0,0,1,
            1,1,1,1,1,1,1,
            0,0,0,0,0,0,0,
            0,0,0,0,0,0,0);//Evelope

        // Set the text.
        $this->setText($str);
        // Get the length of the text (multi byte save).
        $length = mb_strlen($this->text);

        // Set the x position to the size.
        $this->width = $this->x = $this->size;
        $this->y = 0;
        // Set the height to eleven times the size.
        $this->height = $this->size * self::HEIGHT_MULTIPLIER;

        // Start a basic drawing context, even though we don't know the actual width yet.
        $draw = new ImagickDraw();
        $draw->setViewbox(0, 0, $this->width, $this->height);
        $draw->setStrokeWidth(0);

        // Loop through the characters of the text.
        for($i = 0; $i < $length; ++$i)
        {
            // Isolate a character from the text string.
            $char = mb_substr($this->text, $i, 1);

            // If we know this character, draw it.
            if(isset($this->c[mb_ord($char)])) {
                $pixels = $this->c[mb_ord($char)];
                // We know the rows and the pixels, so we can calculate the columns.
                $columns = count($pixels) / self::ROWS;
                $column = 0;
                // Adjust the width of the image with accordance to the width of the character.
                $this->width += $columns * $this->size + $this->size;

                // Loop through the pixels of the character.
                foreach($pixels as $pixel) {
                    // If we reached the last column of the character, go to a new line.
                    if ($column === $columns) {
                        $column = 0;
                        $this->x -= $this->size * $columns;
                        $this->y += $this->size;
                    }

                    // If the pixel is "true", paint it.
                    if($pixel === 1) {
                        // Brand it.
                        $draw->setFillColor(new ImagickPixel($this->deJade()));
                        $draw->rectangle($this->x, $this->y, $this->x + $this->size - 1, $this->y + $this->size - 1);
                        // Counted.
                        $this->ones++;
                    } elseif($pixel === 0) {
                        // Also count zeros.
                        $this->zeros++;
                    }

                    ++$column;
                    // For every pixel, move one column to the right.
                    $this->x += $this->size;
                }

                // Once a character is done painting, also move one column to the right. This creates letter spacing.
                $this->x += $this->size;
                // Reset the top position for a character that might follow.
                $this->y -= $this->size * 8;
            }
        }

        // This is where the magick happens.
        $this->im = new Imagick();
        $this->im->newImage($this->width, $this->height, new ImagickPixel(self::WHITE));
        $this->im->setImageFormat($this->type);

        $this->im->drawImage($draw);
    }

    public function __toString()
    {
        return $this->text;
    }

    public function deJade() {
        $r = mt_rand(0, 127);
        $g = mt_rand(127, 255);
        $b = mt_rand(0, 191);

        $color = "rgba($r, $g, $b, .5)";

        return $color;
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
