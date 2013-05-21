--TEST--
strip_non_ascii() function valid UTF-8 string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(strip_non_ascii('Iñtërnâtiônàlizætiøn'));
?>
--EXPECT--
string(13) "Itrntinliztin"
