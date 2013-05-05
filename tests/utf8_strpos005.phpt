--TEST--
utf8_strpos() function valid string, integer as needle
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strpos('Iñtërnâtiônàlizætiøn', 241);
var_dump($result);
?>
--EXPECT--
int(1)

