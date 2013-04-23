--TEST--
utf8_substr() function valid string, start to big
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_substr('Iñt', 4);
var_dump($result);
?>
--EXPECT--
bool(false)
