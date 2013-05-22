--TEST--
utf8_encode2() function, empty string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_encode2("");
var_dump($result);
?>
--EXPECT--
string(0) ""
