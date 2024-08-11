<?php
declare(strict_types = 1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

$logo = new \deidee\DeLogo('deidee');
var_dump($logo->getWidth());
