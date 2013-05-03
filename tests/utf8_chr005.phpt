--TEST--
utf8_chr() function, 4 byte char
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_chr(66364));
?>
--EXPECT--
string(4) "𐌼"
