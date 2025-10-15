<?php
declare(strict_types = 1);

require_once '../src/class.delogo_svg.php';

$logo = new deidee\Delogo('de logo.svg');
$logo->standalone = true;
$logo->display();
