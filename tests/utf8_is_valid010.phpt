--TEST--
utf8_is_valid() function invalid three octet sequence second
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiônàlizætiøn\xe2\x28\xa1Iñtërnâtiônàlizætiøn"));
?>
--EXPECT--
bool(false)
