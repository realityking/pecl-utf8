--TEST--
utf8_str_split() function valid string, one character
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_str_split('Iñtërnâtiônàlizætiøn'));
?>
--EXPECTF--
array(20) {
  [0]=>
  string(1) "I"
  [1]=>
  string(2) "ñ"
  [2]=>
  string(1) "t"
  [3]=>
  string(2) "ë"
  [4]=>
  string(1) "r"
  [5]=>
  string(1) "n"
  [6]=>
  string(2) "â"
  [7]=>
  string(1) "t"
  [8]=>
  string(1) "i"
  [9]=>
  string(2) "ô"
  [10]=>
  string(1) "n"
  [11]=>
  string(2) "à"
  [12]=>
  string(1) "l"
  [13]=>
  string(1) "i"
  [14]=>
  string(1) "z"
  [15]=>
  string(2) "æ"
  [16]=>
  string(1) "t"
  [17]=>
  string(1) "i"
  [18]=>
  string(2) "ø"
  [19]=>
  string(1) "n"
}
