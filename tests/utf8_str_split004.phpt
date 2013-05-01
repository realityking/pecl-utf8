--TEST--
utf8_str_split() function valid string, long length
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_str_split('Iñtërnâtiônàlizætiøn', 40));
?>
--EXPECTF--
array(1) {
  [0]=>
  string(27) "Iñtërnâtiônàlizætiøn"
}
