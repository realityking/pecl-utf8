--TEST--
utf8_decode2() function, valid UTF-8, codepoints covered by Windows 1252 encoding
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_decode2("Euro sign: \xe2\x82\xac\xc2\xa0");
var_dump($result);
?>
--EXPECT--
string(13) "Euro sign: € "
