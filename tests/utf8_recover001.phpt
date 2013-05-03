--TEST--
utf8_recover() function invalid UTF-8 string, single bad byte
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_recover("Iñtërnâtiôn\xe9àlizætiøn");
var_dump($result);
?>
--EXPECT--
string(30) "Iñtërnâtiôn�àlizætiøn"
