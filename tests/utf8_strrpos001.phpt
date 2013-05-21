--TEST--
utf8_strrpos() function valid UTF-8 string, ASCII needle
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos('Iñtërnâtiônàlizætiøn', 'i');
var_dump($result);
?>
--EXPECT--
int(17)
