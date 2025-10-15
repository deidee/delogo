<?php
declare(strict_types = 1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

$logo = new \deidee\DeLogo('svg default');
$logo->standalone = true;
$logo->parse();
