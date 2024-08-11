<?php
declare(strict_types = 1);

namespace deidee;

use SVG\SVG as SVG;

class DeLogoVector extends DeLogo
{
    public $doc;

    public function build()
    {
        $this->image = new SVG($this->getWidth(), $this->getHeight());
        $this->doc = $this->image->getDocument();
    }
}