--TEST--
utf8_recover() function invalid UTF-8 string, incomplete 4 byte character
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_recover("Iñtërnâtiôn\xf0\x9f\x9aàlizætiøn");
var_dump($result);
?>
--EXPECT--
string(30) "Iñtërnâtiôn�àlizætiøn"
