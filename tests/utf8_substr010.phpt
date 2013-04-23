--TEST--
utf8_substr() function valid string, line fedd
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_substr("Iñ\ntërnâtiônàlizætiøn", 1, 5);
var_dump($result);
?>
--EXPECT--
string(7) "ñ
tër"
