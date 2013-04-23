--TEST--
utf8_substr() function valid string, complete
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_substr('Iñtërnâtiônàlizætiøn', 0);
var_dump($result);
?>
--EXPECT--
string(27) "Iñtërnâtiônàlizætiøn"
