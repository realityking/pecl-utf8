--TEST--
utf8_strlen() function invalid UTF-8 string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_strlen("Iñtërnâtiôn\xe9àlizætiøn"));
?>
--EXPECTF--
Warning: String does not contain valid UTF-8 in %s on line %d
NULL
