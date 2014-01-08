<?php
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('eMacros', __DIR__);
$loader->add('Foo', __DIR__);
$loader->add('Test', __DIR__);
$loader->add('Acme', __DIR__);

date_default_timezone_set('America/Argentina/Buenos_Aires');