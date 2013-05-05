--TEST--
utf8_strrev() function valid string
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_strrev('Iñtërnâtiônàlizætiøn'));
?>
--EXPECT--
string(27) "nøitæzilànôitânrëtñI"
