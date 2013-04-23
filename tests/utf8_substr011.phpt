--TEST--
utf8_substr() function valid string, long length
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_substr('Iñtërnâtiônàlizætiøn', 0, 15536);
var_dump($result);
?>
--EXPECT--
string(27) "Iñtërnâtiônàlizætiøn"
