--TEST--
utf8_is_valid() function invalid ASCII string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("this is an invalid char '\xe9' here"));
?>
--EXPECT--
bool(false)
