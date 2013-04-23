--TEST--
utf8_is_valid() function valid ASCII string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid('ABC 123'));
?>
--EXPECT--
bool(true)
