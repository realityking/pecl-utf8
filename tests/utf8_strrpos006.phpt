--TEST--
utf8_strrpos() function valid UTF-8 string, UTF-8 needle
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos('Iñtërnâtiônàlizætiøn', 'à');
var_dump($result);
?>
--EXPECT--
int(11)
