--TEST--
utf8_is_valid() function invalid four octet sequence
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiônàlizætiøn\xf0\x28\x8c\xbcIñtërnâtiônàlizætiøn"));
?>
--EXPECT--
bool(false)
