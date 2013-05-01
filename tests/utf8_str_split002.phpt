--TEST--
utf8_str_split() function valid string, five characters
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_str_split('Iñtërnâtiônàlizætiøn', 5));
?>
--EXPECTF--
array(4) {
  [0]=>
  string(7) "Iñtër"
  [1]=>
  string(7) "nâtiô"
  [2]=>
  string(6) "nàliz"
  [3]=>
  string(7) "ætiøn"
}
