--TEST--
utf8_strrpos() function valid UTF-8 string, Bug #64890
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos('Internationalization', 'n', -1);
var_dump($result);
?>
--EXPECT--
int(10)
