--TEST--
utf8_encode2() function, ISO 8859-1 compatible string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_encode2("Test \xc4\xd6\xdc");
var_dump($result);
?>
--EXPECT--
string(11) "Test ÄÖÜ"
