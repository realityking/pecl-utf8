--TEST--
utf8_ord() function, 4 byte char
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_ord("\xf0\x90\x8c\xbc"));
?>
--EXPECT--
int(66364)
