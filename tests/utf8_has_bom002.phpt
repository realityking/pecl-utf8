--TEST--
utf8_has_bom() function UTF-8 with BOM
--SKIPIF--
<?php

if(!extension_loaded('utf8')) die('skip ');

 ?>
--FILE--
<?php
$string = file_get_contents(__DIR__ . '/testfiles/utf8bom.txt');
var_dump(utf8_has_bom($string));
?>
--EXPECT--
bool(true)
