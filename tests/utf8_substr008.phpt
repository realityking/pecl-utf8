--TEST--
utf8_substr() function valid string, length negative
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_substr('Iñtërnâtiônàlizætiøn', 10, -2);
var_dump($result);
?>
--EXPECT--
string(10) "nàlizæti"
