--TEST--
utf8_strrpos() function empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos('', 'x');
var_dump($result);
?>
--EXPECT--
bool(false)
