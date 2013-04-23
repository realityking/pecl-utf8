--TEST--
utf8_is_valid() function valid three octet id
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiônàlizætiøn\xe2\x82\xa1Iñtërnâtiônàlizætiøn"));
?>
--EXPECT--
bool(true)
