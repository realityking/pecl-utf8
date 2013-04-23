--TEST--
utf8_is_valid() function valid two octet id
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_is_valid("\xc3\xb1"));
?>
--EXPECT--
bool(true)
