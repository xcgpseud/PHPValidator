<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once "vendor/autoload.php";

use PhpOption\None;
use Validator\Validator;

$pass = [123, 234, 4312];
$fail = [null, None::create(), []];

$v = new Validator();
$func = $v->add()
    ->withKeys([0, 1, 2])
    ->withAction(function ($val) {
        return !empty($val) && !$val instanceof None;
    })->save()->getFunction();

if ($func($pass)) {
    echo "Pass: Passed<br>";
} else {
    echo "Pass: Failed<br>";
}

if ($func($fail)) {
    echo "Fail: Passed<br>";
} else {
    echo "Fail: Failed<br>";
}
