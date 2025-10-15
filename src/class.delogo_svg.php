<?php
declare(strict_types = 1);

namespace deidee;

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/data/chars.php';

use SVG\Nodes\Shapes\SVGRect as SVGRect;
use SVG\Nodes\Structures\SVGGroup;
use SVG\Nodes\Texts\SVGDesc;
use SVG\Nodes\Texts\SVGText;
use SVG\SVG as SVG;

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
    private $standalone = true;
    public $text;
    public $ones = 0;
    public $zeros = 0;
    public $x = 0;
    public $y = 0;
    public $image;
    public $doc;
    public $lines = 1;

    public function __construct($str = self::VENDOR, $settings = [])
    {
        global $c;

        $this->c = $c;

        // Set the text.
        $this->setText($str);
        // Set the number of lines.
        $this->setLines($str);

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
        $this->width += $width;
        $this->doc->setWidth($this->width);
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
        $this->image = new SVG($this->width, $this->height);
        $this->doc = $this->image->getDocument();
        $this->doc->setAttribute('class', 'logo--deidee');

        $desc = new SVGDesc;
        $desc->setValue('deidee logo.');
        $this->doc->addChild($desc);

        $g = new SVGGroup;
        $g->setAttribute('class', 'logotype');
        $g->setAttribute('aria-label', $this->text);

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
                        $rect = new SVGRect($this->x, $this->y, $this->size + mt_rand(0, 3), $this->size + mt_rand(0, 3));
                        // Brand it.
                        $rect->setStyle('fill', $this->deJade());
                        $g->addChild($rect);
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

        $this->doc->addChild($g);

        // Set the appropriate MIME type.
        header('Content-Type: image/svg+xml');

        echo $this->image->toXMLString($this->standalone);
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function setLines($str)
    {
        $this->lines = 1 + mb_substr_count($str, PHP_EOL);
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function setText($str = '')
    {
        $this->text = $str;
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
