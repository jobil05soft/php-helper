<?php

use app\classes\Helper;

require_once('../vendor/autoload.php');
require_once('../config.php');


$data = [
    [
        'nome' => 'Jobilsoft',
        'email' => 'jobilsoft@gmail.com'
    ],
    [
        'nome' => 'Manuel Pedro',
        'email' => 'pedromanuel@gmail.com'
    ],
];

Helper::printData($data, false);

$data1 = Helper::arrayToObject($data);

Helper::printData($data1);