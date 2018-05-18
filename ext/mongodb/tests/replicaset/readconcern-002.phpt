--TEST--
ReadConcern: MongoDB\Driver\Manager::executeQuery() with readConcern option (OP_QUERY)
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"; CLEANUP(REPLICASET_30) ?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$manager = new MongoDB\Driver\Manager(REPLICASET_30);

$bulk = new MongoDB\Driver\BulkWrite();
$bulk->insert(['_id' => 1, 'x' => 1]);
$bulk->insert(['_id' => 2, 'x' => 2]);
$manager->executeBulkWrite(NS, $bulk);

$rc = new MongoDB\Driver\ReadConcern(MongoDB\Driver\ReadConcern::LOCAL);
$query = new MongoDB\Driver\Query(['x' => 2], ['readConcern' => $rc]);

echo throws(function() use ($manager, $query) {
    $manager->executeQuery(NS, $query);
}, 'MongoDB\Driver\Exception\RuntimeException'), "\n";

$rc = new MongoDB\Driver\ReadConcern(MongoDB\Driver\ReadConcern::MAJORITY);
$query = new MongoDB\Driver\Query(['x' => 2], ['readConcern' => $rc]);

echo throws(function() use ($manager, $query) {
    $manager->executeQuery(NS, $query);
}, 'MongoDB\Driver\Exception\RuntimeException'), "\n";

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
OK: Got MongoDB\Driver\Exception\RuntimeException
The selected server does not support readConcern
OK: Got MongoDB\Driver\Exception\RuntimeException
The selected server does not support readConcern
===DONE===
