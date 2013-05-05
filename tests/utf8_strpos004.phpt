--TEST--
utf8_strpos() function empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strpos('', 'â');
var_dump($result);
?>
--EXPECT--
bool(false)
