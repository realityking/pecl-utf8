--TEST--
utf8_str_split() function valid string, invalid length
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(str_split('Iñtërnâtiônàlizætiøn', -1));
?>
--EXPECTF--
Warning: str_split(): The length of each segment must be greater than zero in %s on line %d
bool(false)
