--TEST--
utf8_strpos() function invalid string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strpos("Iñtërnâtiôn\xe9àlizætiøn", 'æ');
var_dump($result);
?>
--EXPECTF--
Warning: utf8_strpos(): Haystack does not contain valid UTF-8 in %s on line %d
NULL
