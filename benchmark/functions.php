<?php

function strlen_php($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = strlen($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strlen_mb($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = mb_strlen($string, 'UTF-8');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strlen_iconv($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = iconv_strlen($string, 'UTF-8');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strlen_phputf8($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = phputf8\strlen($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strlen_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\strlen($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strlen_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_strlen($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function substr_php($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = substr($string, 2, 6);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function substr_mb($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = mb_substr($string, 2, 6, 'UTF-8');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function substr_iconv($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = iconv_substr($string, 2, 6, 'UTF-8');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function substr_phputf8($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = phputf8\substr($string, 2, 6);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function substr_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\substr($string, 2, 6);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function substr_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_substr($string, 2, 6);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function string_is_ascii_phputf8($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = phputf8\string_is_ascii($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function string_is_ascii_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = string_is_ascii($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_is_valid_phputf8($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = phputf8\utf8_is_valid($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_is_valid_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\utf8_is_valid($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_is_valid_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_is_valid($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function ord_php($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = ord($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function ord_phputf8($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = phputf8\utf8_ord($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function ord_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\utf8_ord($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function ord_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_ord($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function str_split_php($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = str_split($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function str_split_phputf8($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = phputf8\str_split($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function str_split_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\str_split($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function str_split_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_str_split($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function chr_php($int, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = chr($int);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function chr_patchwork($int, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\chr($int);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function chr_pecl($int, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_chr($int);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrev_php($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = strrev($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrev_phputf8($string, $c)
{
	$i = 0;
	$t = strrev(true);
	while($i < $c) {
		$value = phputf8\strrev($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrev_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\strrev($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrev_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_strrev($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strpos_php($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = strpos($string, 'i', 6);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strpos_mb($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = mb_strpos($string, 'i', 6, 'UTF-8');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strpos_iconv($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = iconv_strpos($string, 'i', 6, 'UTF-8');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strpos_phputf8($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = phputf8\strpos($string, 'i', 6);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strpos_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\strpos($string, 'i', 6);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strpos_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_strpos($string, 'i', 6);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrpos_php($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = strrpos($string, 'i');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrpos_mb($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = mb_strrpos($string, 'i', 0, 'UTF-8');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrpos_iconv($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = iconv_strrpos($string, 'i', 'UTF-8');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrpos_phputf8($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = phputf8\strrpos($string, 'i');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrpos_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\strrpos($string, 'i');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strrpos_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_strrpos($string, 'i');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strip_non_ascii_phputf8($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = phputf8\strip_non_ascii($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function strip_non_ascii_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = strip_non_ascii($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_encode_php($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_encode($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_encode_mb($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = mb_convert_encoding($string, 'UTF-8', 'ISO-8859-1');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_encode_iconv($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = iconv("UTF-8", "ISO-8859-1", $string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_encode_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\utf8_encode($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_encode_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_encode2($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_decode_php($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_decode($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_decode_mb($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_decode_iconv($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = iconv("ISO-8859-1", "UTF-8", $string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_decode_patchwork($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = patchwork\utf8_decode($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}

function utf8_decode_pecl($string, $c)
{
	$i = 0;
	$t = microtime(true);
	while($i < $c) {
		$value = utf8_decode2($string);
		++$i;
	}
	$tmp = microtime(true) - $t;

	return $tmp;
}
