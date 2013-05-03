--TEST--
utf8_recover() function valid UTF-8 string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_recover("Iñtërnâtiônàlizætiøn");
var_dump($result);
?>
--EXPECT--
string(27) "Iñtërnâtiônàlizætiøn"
