--TEST--
utf8_is_valid() function invalid five octet sequence
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiônàlizætiøn\xf8\xa1\xa1\xa1\xa1Iñtërnâtiônàlizætiøn"));
?>
--EXPECT--
bool(false)
