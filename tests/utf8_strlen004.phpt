--TEST--
utf8_strlen() function empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_strlen(''));
?>
--EXPECT--
int(0)
