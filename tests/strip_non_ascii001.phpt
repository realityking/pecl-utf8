--TEST--
strip_non_ascii() function empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(strip_non_ascii(''));
?>
--EXPECT--
string(0) ""
