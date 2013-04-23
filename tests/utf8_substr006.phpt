--TEST--
utf8_substr() function valid string, length beyond string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_substr('Iñt', 1, 5);
var_dump($result);
?>
--EXPECT--
string(3) "ñt"
