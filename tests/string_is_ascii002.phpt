--TEST--
string_is_ascii() function valid ASCII string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(string_is_ascii('ABC 123'));
?>
--EXPECT--
bool(true)
