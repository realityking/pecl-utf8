--TEST--
utf8_strrpos() function invalid UTF-8 string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos("Iñtërnâtiôn\xe9àlizætiøn", 'æ');
var_dump($result);
?>
--EXPECTF--
Warning: utf8_strrpos(): Haystack does not contain valid UTF-8 in %s on line %d
NULL
