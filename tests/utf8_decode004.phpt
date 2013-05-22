--TEST--
utf8_decode2() function, valid UTF-8 with codepoints covered by CP 1251
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_decode("I\xc3\xb1t\xc3\xabrn\xc3\xa2ti\xc3\xb4n\xc3\xa0liz\xc3\xa6ti\xc3\xb8n");
var_dump($result);
?>
--EXPECT--
string(20) "Iñtërnâtiônàlizætiøn"
