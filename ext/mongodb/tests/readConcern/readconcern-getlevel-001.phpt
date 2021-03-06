--TEST--
MongoDB\Driver\ReadConcern::getLevel()
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$tests = [
    null,
    MongoDB\Driver\ReadConcern::LOCAL,
    MongoDB\Driver\ReadConcern::MAJORITY,
    'not-yet-supported',
];

foreach ($tests as $test) {
    $rc = new MongoDB\Driver\ReadConcern($test);
    var_dump($rc->getLevel());
}

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
NULL
string(5) "local"
string(8) "majority"
string(17) "not-yet-supported"
===DONE===
