--TEST--
utf8_is_valid() function invalid two octet sequence
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiônàlizætiøn \xc3\x28 Iñtërnâtiônàlizætiøn"));
?>
--EXPECT--
bool(false)
