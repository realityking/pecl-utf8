--TEST--
utf8_strrev() function empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_strrev(''));
?>
--EXPECT--
string(0) ""
