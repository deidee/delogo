<?php

require_once '../src/class.delogo.php';

$logo = new deidee\Delogo('delogo.svg');
$logo->setType('svg');
$logo->display();
