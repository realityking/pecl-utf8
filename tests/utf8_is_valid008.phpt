--TEST--
utf8_is_valid() function invalid id between two and three
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiônàlizætiøn\xa0\xa1Iñtërnâtiônàlizætiøn"));
?>
--EXPECT--
bool(false)
