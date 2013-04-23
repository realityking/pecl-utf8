--TEST--
utf8_substr() function valid string, start negative
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_substr('Iñtërnâtiônàlizætiøn', -4);
var_dump($result);
?>
--EXPECT--
string(5) "tiøn"
