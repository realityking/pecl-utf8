--TEST--
utf8_substr() function valid string, 2 chars from beginning
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_substr('Iñtërnâtiônàlizætiøn', 0, 2);
var_dump($result);
?>
--EXPECT--
string(3) "Iñ"
