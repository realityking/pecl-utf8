--TEST--
utf8_decode2() function, invalid UTF-8
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$result = utf8_decode("I\xc3\xb1t\xc3\xabrn\xc3\xa2t\xe9i\xc3\xb4n\xc3\xa0liz\xc3\xa6ti\xc3\xb8n");
var_dump($result);
?>
--EXPECT--
string(21) "Iñtërnât?iônàlizætiøn"
