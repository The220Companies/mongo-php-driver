--TEST--
MongoDB\Driver\Cursor query result iteration through IteratorIterator
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"; CLEANUP(STANDALONE) ?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$manager = new MongoDB\Driver\Manager(STANDALONE);

$bulk = new MongoDB\Driver\BulkWrite();
$bulk->insert(array('_id' => 1, 'x' => 1));
$bulk->insert(array('_id' => 2, 'x' => 1));
$manager->executeBulkWrite(NS, $bulk);

$cursor = $manager->executeQuery(NS, new MongoDB\Driver\Query(array("x" => 1)));

foreach (new IteratorIterator($cursor) as $document) {
    var_dump($document);
}

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
object(stdClass)#%d (2) {
  ["_id"]=>
  int(1)
  ["x"]=>
  int(1)
}
object(stdClass)#%d (2) {
  ["_id"]=>
  int(2)
  ["x"]=>
  int(1)
}
===DONE===
