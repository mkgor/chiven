<?php

require_once 'vendor/autoload.php';


$files = [
    'name' => [
        'something1.jpg',
        'something2.jpg'
    ],
    'type' => [
        'something1.jpg',
        'something2.jpg'
    ],
    'tmp_name' => [
        'something1.jpg',
        'something2.jpg'
    ],
    'error' => [
        'something1.jpg',
        'something2.jpg'
    ],
    'size' => [
        0,
        0
    ],
];

$request = new \Chiven\Http\Request($files);

var_dump($request->getFiles());