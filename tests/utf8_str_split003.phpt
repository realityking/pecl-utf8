--TEST--
utf8_str_split() function valid string, six characters
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_str_split('Iñtërnâtiônàlizætiøn', 6));
?>
--EXPECTF--
array(4) {
  [0]=>
  string(8) "Iñtërn"
  [1]=>
  string(9) "âtiônà"
  [2]=>
  string(7) "lizæti"
  [3]=>
  string(3) "øn"
}
