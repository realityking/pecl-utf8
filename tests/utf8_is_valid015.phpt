--TEST--
utf8_is_valid() function invalid six octet sequence
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiônàlizætiøn\xfc\xa1\xa1\xa1\xa1\xa1Iñtërnâtiônàlizætiøn"));
?>
--EXPECT--
bool(false)
