<?php
declare(strict_types = 1);

require_once '../src/DeLogo.php';

$logo = new \deidee\DeLogo('deidee');
var_dump($logo->getWidth());
