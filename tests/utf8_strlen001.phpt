--TEST--
utf8_strlen() function UTF-8 string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_strlen('Iñtërnâtiônàlizætiøn'));
?>
--EXPECT--
int(20)
