--TEST--
utf8_strrev() function valid string with linefeed
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
var_dump(utf8_strrev("Iñtërnâtiôn\nàlizætiøn"));
?>
--EXPECT--
string(28) "nøitæzilà
nôitânrëtñI"
