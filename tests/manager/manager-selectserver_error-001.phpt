--TEST--
MongoDB\Driver\Manager::selectServer() should not issue warning before exception
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"; ?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$rp = new MongoDB\Driver\ReadPreference(MongoDB\Driver\ReadPreference::RP_PRIMARY);

// Invalid host cannot be resolved
$manager = new MongoDB\Driver\Manager('mongodb://invalid.host:27017', ['serverSelectionTimeoutMS' => 1]);

echo throws(function() use ($manager, $rp) {
    $manager->selectServer($rp);
}, 'MongoDB\Driver\Exception\RuntimeException'), "\n";

// Valid host refuses connection
$manager = new MongoDB\Driver\Manager('mongodb://localhost:54321', ['serverSelectionTimeoutMS' => 1]);

echo throws(function() use ($manager, $rp) {
    $manager->selectServer($rp);
}, 'MongoDB\Driver\Exception\RuntimeException'), "\n";

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
OK: Got MongoDB\Driver\Exception\RuntimeException
No suitable servers found (`serverselectiontryonce` set): %s
OK: Got MongoDB\Driver\Exception\RuntimeException
No suitable servers found (`serverselectiontryonce` set): %s
===DONE===