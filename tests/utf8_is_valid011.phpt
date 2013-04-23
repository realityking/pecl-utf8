--TEST--
utf8_is_valid() function invalid three octet sequence third
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiônàlizætiøn\xe2\x82\x28Iñtërnâtiônàlizætiøn"));
?>
--EXPECT--
bool(false)
