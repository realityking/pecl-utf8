--TEST--
utf8_is_valid() function valid empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid(''));
?>
--EXPECT--
bool(true)
