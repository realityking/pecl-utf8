This PECL extension for PHP offers functions to handle UTF-8 encoded strings. It has no external dependencies.

[Benchmark results]

The following functions are implemented:

* utf8_is_valid - Checks whether a string is valid UTF-8
* utf8_strlen
* utf8_substr
* utf8_strpos
* utf8_strrpos
* utf8_str_split
* utf8_strrev
* utf8_chr
* utf8_ord
* utf8_recover
* utf8_has_bom
* string_is_ascii
* strip_non_ascii
* utf8_encode2
* utf8_decode2

BUILDING ON UNIX etc.
=====================

To compile your new extension, you will have to execute the following steps:

1.  $ ./phpize
2.  $ ./configure [--enable--utf8]
3.  $ make
4.  $ make test
5.  $ [sudo] make install
