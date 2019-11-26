<?php

require_once '../src/class.delogo.php';

$logo = new Delogo('delogo.svg');
$logo->setType('svg');
$logo->display();
