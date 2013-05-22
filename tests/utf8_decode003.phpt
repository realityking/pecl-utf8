--TEST--
utf8_decode2() function, empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_decode2('');
var_dump($result);
?>
--EXPECT--
string(0) ""
