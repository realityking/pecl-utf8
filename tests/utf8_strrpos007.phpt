--TEST--
utf8_strrpos() function valid UTF-8 string, needle that occurs multiple times
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos('Iñtërnâtiônàlizætiøn', 'n');
var_dump($result);
?>
--EXPECT--
int(19)
