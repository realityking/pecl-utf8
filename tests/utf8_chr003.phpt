--TEST--
utf8_chr() function, 2 byte char
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_chr(241));
?>
--EXPECT--
string(2) "ñ"
