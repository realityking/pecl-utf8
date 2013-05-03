--TEST--
utf8_chr() function, ASCII char
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_chr(97));
?>
--EXPECT--
string(1) "a"
