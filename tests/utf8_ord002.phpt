--TEST--
utf8_ord() function, ASCII char
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_ord('a'));
?>
--EXPECT--
int(97)
