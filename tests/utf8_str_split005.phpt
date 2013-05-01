--TEST--
utf8_str_split() function valid string, new line
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_str_split("Iñtërn\nâtiônàl\nizætiøn\n"));
?>
--EXPECTF--
array(23) {
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
  string(1) "
"
  [7]=>
  string(2) "â"
  [8]=>
  string(1) "t"
  [9]=>
  string(1) "i"
  [10]=>
  string(2) "ô"
  [11]=>
  string(1) "n"
  [12]=>
  string(2) "à"
  [13]=>
  string(1) "l"
  [14]=>
  string(1) "
"
  [15]=>
  string(1) "i"
  [16]=>
  string(1) "z"
  [17]=>
  string(2) "æ"
  [18]=>
  string(1) "t"
  [19]=>
  string(1) "i"
  [20]=>
  string(2) "ø"
  [21]=>
  string(1) "n"
  [22]=>
  string(1) "
"
}
