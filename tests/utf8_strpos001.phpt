--TEST--
utf8_strpos() function valid string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_strpos('Iñtërnâtiônàlizætiøn', 'â');
var_dump($result);
?>
--EXPECT--
int(6)
