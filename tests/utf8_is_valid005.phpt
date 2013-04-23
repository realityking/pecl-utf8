--TEST--
utf8_is_valid() function invalid UTF-8 string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("Iñtërnâtiôn\xe9àlizætiøn"));
?>
--EXPECT--
bool(false)
