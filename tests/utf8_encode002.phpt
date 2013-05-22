--TEST--
utf8_encode2() function, string with Windows 1252 encoding
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_encode2("Euro sign: \x80\xa0");
var_dump($result);
?>
--EXPECT--
string(16) "Euro sign: € "
