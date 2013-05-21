--TEST--
utf8_strrpos() function valid UTF-8 string, negative offset larger than the string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos('Iñtërnâtiônâlizâtiøn', 'n', -21);
var_dump($result);
?>
--EXPECTF--
Warning: utf8_strrpos(): Offset is greater than the length of haystack string in %s on line %d
bool(false)
