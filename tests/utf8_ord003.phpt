--TEST--
utf8_ord() function, 2 byte char
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_ord('ñ'));
?>
--EXPECT--
int(241)
