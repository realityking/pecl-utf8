--TEST--
utf8_ord() function, 3 byte char
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_ord('₧'));
?>
--EXPECT--
int(8359)
