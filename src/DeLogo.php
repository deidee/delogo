<?php
declare(strict_types = 1);

namespace deidee;

require_once dirname(__DIR__) . '/data/chars.php';

class DeLogo
{
    const HEIGHT_MULTIPLIER = 11;
    const ROWS = 9;
    const VENDOR = 'deidee';
    const BLACK = '#000000';
    const RED = '#ff0000'; // The "foo" of colors. Used for testing.
    const WHITE = '#ffffff';

    private $c;
    private $size = 24;
    private $width = 300;
    private $height = 300;
    private $ones;
    private $zeros;

    public function __construct($str = self::VENDOR, $settings = [])
    {
        global $c;

        $this->c = $c;

        // Set the text.
        $this->setText($str);
    }

    public function setText($str = '')
    {
        $this->text = $str;

        // Reset the width.
        $this->setWidth(0);

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
}

