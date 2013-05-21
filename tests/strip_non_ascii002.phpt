--TEST--
strip_non_ascii() function valid ASCII string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(strip_non_ascii('ABC 123'));
?>
--EXPECT--
string(7) "ABC 123"
