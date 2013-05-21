--TEST--
utf8_strrpos() function valid UTF-8 string, negative offset
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos('Iñtërnâtiônâlizâtiøn', 'â', -5);
var_dump($result);
?>
--EXPECT--
int(11)
