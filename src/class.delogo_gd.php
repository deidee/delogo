<?php
declare(strict_types = 1);

namespace deidee;

require_once dirname(__DIR__) . '/data/chars.php';

class Delogo
{
    const HEIGHT_MULTIPLIER = 11;
    const ROWS = 9;
    const VENDOR = 'deidee';
    const RED = '#ff0000'; // The "foo" of colors. Used for testing.
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
        global $c;

        $this->c = $c;

        // Set the text.
        $this->setText($str);

        // Set the positions to the size so we get some sensible whitespace.
        $this->width = $this->x = $this->y = $this->size;
        // Apply multiplier to set the height.
        $this->height = $this->size * self::HEIGHT_MULTIPLIER;
    }

    public function __toString()
    {
        return $this->text;
    }

    public function addWidth($width)
    {
        $this->setWidth($this->width + $width);
    }

    public function deJade()
    {
        $r = mt_rand(0, 127);
        $g = mt_rand(127, 255);
        $b = mt_rand(0, 191);

        return "rgba($r, $g, $b, .5)";
    }

    public function display()
    {
        // Get the length of the text (multi-byte safe).
        $length = mb_strlen($this->text);

        // Start a basic drawing context, even though we don't know the actual width yet.
        // TODO: Set a realistic width.
        $this->im = imagecreatetruecolor(10000, $this->height * self::HEIGHT_MULTIPLIER);
        imagesavealpha($this->im, true);
        $trans = imagecolorallocatealpha($this->im, 0, 0, 0, 127);
        imagefill($this->im, 0, 0, $trans);

        // Loop through the characters of the text.
        for($i = 0; $i < $length; ++$i)
        {
            // Isolate a character from the text string (multi-byte safe).
            $char = mb_substr($this->text, $i, 1);

            // If we know this character, draw it.
            if(isset($this->c[mb_ord($char)])) {
                $pixels = $this->c[mb_ord($char)];
                // Apply correction for space characters.
                if(empty($pixels)) $this->y += 8 * $this->size;
                // We know the rows and the pixels, so we can calculate the columns.
                $columns = count($pixels) / self::ROWS;
                $column = 0;
                // Adjust the width of the image with accordance to the width of the character.
                $this->addWidth($columns * $this->size + $this->size);

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
                        $r = mt_rand(0, 127);
                        $g = mt_rand(127, 255);
                        $b = mt_rand(0, 191);
                        $jade = imagecolorallocatealpha($this->im, $r, $g, $b, 63);
                        $x2 = $this->x + $this->size + mt_rand(-1, 2);
                        $y2 = $this->y + $this->size + mt_rand(-1, 2);
                        imagefilledrectangle($this->im, $this->x, $this->y, $x2, $y2, $jade);
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

        // This is where the not-magick happens.
        $this->im2 = imagecreatetruecolor($this->width, $this->height);
        imagefill($this->im2, 0, 0, 0xffffff);
        imagecopyresampled($this->im2, $this->im, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height);

        // Set the appropriate MIME type.
        header('Content-Type: image/png');
        imagepng($this->im2);
        imagedestroy($this->im);
        imagedestroy($this->im2);
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function setText($str = '')
    {
        $this->text = $str;
    }

    public function setType($type = '')
    {
        $this->type = $type;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setX($x)
    {
        $this->x = $x;
    }

    public function setY($y)
    {
        $this->y = $y;
    }
}
