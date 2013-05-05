--TEST--
utf8_strpos() function ASCII string, first byte found
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strpos('noitasilanoitanretnI', 'n');
var_dump($result);
?>
--EXPECT--
int(0)

