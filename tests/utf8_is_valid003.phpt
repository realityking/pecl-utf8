--TEST--
utf8_is_valid() function valid UTF-8 string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid('Iñtërnâtiônàlizætiøn'));
?>
--EXPECT--
bool(true)
