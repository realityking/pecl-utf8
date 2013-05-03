--TEST--
utf8_chr() function, empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_chr(0));
?>
--EXPECT--
string(0) ""
