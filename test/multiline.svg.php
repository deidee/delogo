<?php
declare(strict_types = 1);

require_once '../src/class.delogo_svg.php';

$logo = new deidee\Delogo("Regel 1\r\nRegel 2");
var_dump($logo->lines);
