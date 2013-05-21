--TEST--
utf8_strrpos() function ASCII string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strrpos('Internationalization', 'i');
var_dump($result);
?>
--EXPECT--
int(17)
