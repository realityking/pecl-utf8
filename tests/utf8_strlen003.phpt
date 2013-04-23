--TEST--
utf8_strlen() function ASCII string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_strlen('ABC 123'));
?>
--EXPECT--
int(7)
