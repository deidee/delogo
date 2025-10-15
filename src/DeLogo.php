<?php
declare(strict_types = 1);

namespace deidee;

use SVG\Nodes\Shapes\SVGRect as SVGRect;
use SVG\Nodes\Structures\SVGGroup;
use SVG\Nodes\Texts\SVGDesc;
use SVG\SVG as SVG;

class DeLogo
{
    const DEFAULT_SIZE = 24;
    const DEFAULT_TYPE = 'svg';
    const HEIGHT_MULTIPLIER = 11;
    const ROWS = 9;
    const VENDOR = 'deidee';
    const BLACK = '#000000';
    const RED = '#ff0000'; // The "foo" of colors. Used for testing.
    const WHITE = '#ffffff';

    private $c;
    private $size = self::DEFAULT_SIZE;
    private $width = 300;
    private $height = 300;
    private $ones;
    private $zeros;
    private $types = ['jpg', 'png', 'svg'];
    // This is where the GD, Imagick, or SVG image lives when building.
    private $image;
    // This is where the SVG document root will live when building.
    private $doc;
    // This is where we store colors.
    private $palette = array();
    public $standalone = true;

    protected $text = self::VENDOR;
    protected $type = self::DEFAULT_TYPE;
    protected $x = self::DEFAULT_SIZE;
    protected $y = self::DEFAULT_SIZE;
    // TODO: Consider making it an option to change this value. In that case, the width of the image should be adjusted accordingly.
    protected $letterspacing = 1;

    public function __construct($str = self::VENDOR, $settings = [])
    {
        require dirname(__DIR__) . '/data/chars.php';

        /** @var array $c */
        $this->c = $c;

        // Set the text.
        $this->setText($str);
    }

    public function setText($str = '')
    {
        $this->text = $str;

        // Reset the height.
        $this->setHeight($this->size * self::HEIGHT_MULTIPLIER);
        // Reset the width.
        $this->setWidth($this->x);

        // Get the length of the text (multi-byte safe).
        $length = mb_strlen($this->text);

        for($i = 0; $i < $length; ++$i)
        {
            // Isolate a character from the text string (multi-byte safe).
            $char = mb_substr($this->text, $i, 1);

            // If we know this character, draw it.
            if(isset($this->c[mb_ord($char)])) {
                // Get the relevant pixel values.
                $pixels = $this->c[mb_ord($char)];
                // Calculate the number of columns this character has.
                $columns = count($pixels) / self::ROWS;
                // Calculate the width of this character.
                $width = $columns * $this->size + $this->size;
                // Calculate the one-values in this character.
                $ones = array_sum($pixels);
                // Calculate the zero-values in this character.
                $zeros = count($pixels) - $ones;
                // Add the one-values of this character to the total.
                $this->addOnes($ones);
                // Add the zero-values of this character to the total.
                $this->addZeros($zeros);
                // Add the width of this character to the total.
                $this->addWidth($width);
            }
        }

        $this->populatePalette();
    }

    public function build()
    {
        switch($this->type):
            case self::DEFAULT_TYPE:
            default:
                $this->buildVectorImage();
        endswitch;

        return $this->image;
    }

    private function buildVectorImage()
    {
        $this->image = new SVG;
        $this->doc = $this->image->getDocument();
        $this->doc->setAttribute('viewBox', "0 0 {$this->width} {$this->height}");

        $desc = new SVGDesc;
        $desc->setValue('deidee logo.');
        $this->doc->addChild($desc);

        $g = new SVGGroup;
        $g->setAttribute('class', 'logotype');
        $g->setAttribute('aria-label', $this->text);

        $length = mb_strlen($this->text);
        $one = 0;

        for($i = 0; $i < $length; ++$i) {
            $char = mb_substr($this->text, $i, 1);

            if(isset($this->c[mb_ord($char)])) {
                $pixels = $this->c[mb_ord($char)];
                // Apply correction for space characters.
                if(empty($pixels)) $this->y += 8 * $this->size;
                // Calculate character columns.
                $columns = count($pixels) / self::ROWS;
                $column = 0;

                foreach($pixels as $pixel) {
                    // Apply correction for space characters.
                    if(empty($pixels)) $this->y += 8 * $this->size;

                    if ($column === $columns) {
                        $column = 0;
                        $this->x -= $this->size * $columns;
                        $this->y += $this->size;
                    }

                    // If the pixel is "true", paint it.
                    if($pixel === 1) {
                        $rect = new SVGRect($this->x, $this->y, $this->size + mt_rand(0, 3), $this->size + mt_rand(0, 3));
                        // Brand it.
                        $rect->setStyle('fill', $this->palette[$one]);
                        $one++;
                        $g->addChild($rect);
                    } else {
                        // Skip.
                    }

                    ++$column;
                    // For every pixel, move one column to the right.
                    $this->x += $this->size;
                }

                $this->x += $this->size * $this->letterspacing;
                $this->y -= $this->size * 8;
            }
        }

        $this->doc->addChild($g);
    }

    public function addWidth($width)
    {
        $this->setWidth($this->width + $width);
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function addHeight($height)
    {
        $this->setHeight($this->height + $height);
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize($size = self::DEFAULT_SIZE)
    {
        $this->size = $size;
    }

    private function addOnes($ones)
    {
        $this->ones += $ones;
    }

    public function getOnes(): int
    {
        return $this->ones;
    }

    private function addZeros($zeros)
    {
        $this->zeros += $zeros;
    }

    public function getZeros(): int
    {
        return $this->zeros;
    }

    protected function populatePalette()
    {
        for($i = 0; $i < $this->ones; $i++) {
            $this->palette[] = $this->deJade();
        }
    }

    public function setType($type = self::DEFAULT_TYPE)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMimeType(): string
    {
        switch($this->type):
            case 'svg':
            default:
                return 'image/svg+xml';
                break;
        endswitch;
    }

    public function __toString()
    {
        $this->build();

        switch($this->type):
            case self::DEFAULT_TYPE;
            default:
                return $this->image->toXMLString();
        endswitch;
    }

    public function parse()
    {
        switch($this->type):
            case self::DEFAULT_TYPE:
            default:
                header('Content-Type: ' . $this->getMimeType());

                echo $this->image->toXMLString($this->standalone);
        endswitch;
    }

    public function deJade()
    {
        $r = mt_rand(0, 127);
        $g = mt_rand(127, 255);
        $b = mt_rand(0, 191);

        return "rgba($r, $g, $b, .5)";
    }
}

