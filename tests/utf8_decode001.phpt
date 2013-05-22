--TEST--
utf8_decode2() function, valid UTF-8, codepoints covered by ISO 8859-1
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_decode2("Test \xc3\x84\xc3\x96\xc3\x9c");
var_dump($result);
?>
--EXPECT--
string(8) "Test ÄÖÜ"
