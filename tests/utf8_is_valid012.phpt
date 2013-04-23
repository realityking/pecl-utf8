--TEST--
utf8_is_valid() function valid four octet id
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiônàlizætiøn\xf0\x90\x8c\xbcIñtërnâtiônàlizætiøn"));
?>
--EXPECT--
bool(true)
