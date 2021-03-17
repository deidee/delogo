<?php
declare(strict_types = 1);

require_once '../src/class.delogo.php';

$logo = new deidee\Delogo('delogo.gif');
$logo->setType('gif');
$logo->display();
