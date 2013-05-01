--TEST--
utf8_ord() function, empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_ord(''));
?>
--EXPECT--
int(0)
