<?php

require_once 'vendor/autoload.php';

$request = new \Chiven\Http\Request();
$request->fromGlobals();

$chiven = new \Chiven\Bootstrap();
$chiven->setFormat(new \Chiven\Format\Json());

//Request handling...

echo $chiven->getFormat()->responseDecorator(new \Chiven\Http\Response\Response());
