--TEST--
utf8_recover() function invalid UTF-8 string, two bad bytes in sequence
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_recover("Iñtërnâtiôn\xe9\xe9àlizætiøn");
var_dump($result);
?>
--EXPECT--
string(33) "Iñtërnâtiôn��àlizætiøn"
