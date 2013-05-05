--TEST--
utf8_strpos() function valid string, with offset
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strpos('Iñtërnâtiônàlizætiøn', 'n', 11);
var_dump($result);
?>
--EXPECT--
int(19)
