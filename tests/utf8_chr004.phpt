--TEST--
utf8_chr() function, 3 byte char
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_chr(8359));
?>
--EXPECT--
string(3) "₧"
