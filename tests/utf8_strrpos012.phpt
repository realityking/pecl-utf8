--TEST--
utf8_strrpos() function valid UTF-8 string, integer as needle
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos('Iñtërnâtiônâlizâtiøn', 241);
var_dump($result);
?>
--EXPECTF--
int(1)
