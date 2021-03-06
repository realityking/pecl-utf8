/*
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,       |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt.                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Authors: Rouven Weßling <me@rouvenwessling.de>                      |
   +----------------------------------------------------------------------+
*/

#include "php_utf8.h"

#if HAVE_UTF8

#include "lib/utf8tools.h"

/* {{{ utf8_functions[] */
function_entry utf8_functions[] = {
	PHP_FE(utf8_is_valid       , utf8_is_valid_arg_info)
	PHP_FE(utf8_strlen         , utf8_strlen_arg_info)
	PHP_FE(utf8_substr         , utf8_substr_arg_info)
	PHP_FE(utf8_strpos         , utf8_strpos_arg_info)
	PHP_FE(utf8_strrpos        , utf8_strrpos_arg_info)
	PHP_FE(utf8_str_split      , utf8_str_split_arg_info)
	PHP_FE(utf8_strrev         , utf8_strrev_arg_info)
	PHP_FE(utf8_chr            , utf8_chr_arg_info)
	PHP_FE(utf8_ord            , utf8_ord_arg_info)
	PHP_FE(utf8_recover        , utf8_recover_arg_info)
	PHP_FE(utf8_has_bom        , utf8_has_bom_arg_info)
	PHP_FE(string_is_ascii     , string_is_ascii_arg_info)
	PHP_FE(strip_non_ascii     , strip_non_ascii_arg_info)
	PHP_FE(utf8_encode2        , utf8_encode2_arg_info)
	PHP_FE(utf8_decode2        , utf8_decode2_arg_info)
	{ NULL, NULL, NULL }
};
/* }}} */


/* {{{ utf8_module_entry
 */
zend_module_entry utf8_module_entry = {
	STANDARD_MODULE_HEADER,
	"utf8",
	utf8_functions,
	NULL, /* PHP_MINIT */
	NULL, /* PHP_MSHUTDOWN */
	NULL, /* PHP_RINIT */
	NULL, /* PHP_RSHUTDOWN */
	PHP_MINFO(utf8),
	PHP_UTF8_VERSION,
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_UTF8
ZEND_GET_MODULE(utf8)
#endif

/* {{{ PHP_MINFO_FUNCTION */
PHP_MINFO_FUNCTION(utf8)
{
	php_printf("UTF-8\n");
	php_info_print_table_start();
	php_info_print_table_row(2, "Version", PHP_UTF8_VERSION " (devel)");
	php_info_print_table_row(2, "Released", "2013-04-23");
	php_info_print_table_row(2, "Authors", "Rouven Weßling 'me@rouvenwessling.de' (lead)\n");
	php_info_print_table_end();
}
/* }}} */

/* {{{ utf8_needle_char
 */
static int utf8_needle_char(zval *needle, char8_t **target TSRMLS_DC)
{
	switch (Z_TYPE_P(needle)) {
		case IS_LONG:
		case IS_BOOL:
			*target = utf8_char_from_codepoint((uint32_t)Z_LVAL_P(needle));
			return SUCCESS;
		case IS_NULL:
			*target = emalloc(1);
			*target[0] = '\0';
			return SUCCESS;
		case IS_DOUBLE:
			*target = utf8_char_from_codepoint((uint32_t)Z_DVAL_P(needle));
			return SUCCESS;
		/* I don't know what the IS_OBJECT code that was here in the PHP version is supposed to do */
		default: {
			php_error_docref(NULL TSRMLS_CC, E_WARNING, "needle is not a string or an integer");
			return FAILURE;
		 }
	}
}
/* }}} */

/* {{{ proto bool utf8_is_valid(string str)
   */
PHP_FUNCTION(utf8_is_valid)
{
	char8_t  *str = NULL;
	int       str_len = 0;
	zend_bool valid = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	if (str_len == 0) {
		RETURN_TRUE;
	}

	valid = utf8_is_valid(str, str_len);

	RETURN_BOOL(valid);
}
/* }}} utf8_is_valid */


/* {{{ proto int utf8_strlen(string str)
   */
PHP_FUNCTION(utf8_strlen)
{
	char8_t  *str = NULL;
	int       str_len = 0;
	zend_bool valid;
	size_t    count;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	if (str_len == 0) {
		RETURN_LONG(0);
	}

	count = utf8_strlen(str, &valid);

	if (!valid) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "String does not contain valid UTF-8");
		return;
	}

	RETURN_LONG(count);
}
/* }}} utf8_strlen */

/* {{{ proto mixed utf8_substr(string str, int start [, int length])
   */
PHP_FUNCTION(utf8_substr)
{
	char8_t  *str = NULL;
	char8_t  *result = NULL;
	int       str_len = 0, utf8_len = 0;
	zend_bool valid;
	long      l = 0, f;
	int       argc = ZEND_NUM_ARGS();

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "sl|l", &str, &str_len, &f, &l) == FAILURE) {
		return;
	}

	utf8_len = utf8_strlen(str, &valid);

	if (!valid) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "String does not contain valid UTF-8");
		RETURN_FALSE;
	}

	if (argc > 2) {
		if ((l < 0 && -l > utf8_len)) {
			RETURN_FALSE;
		} else if (l > utf8_len) {
			l = utf8_len;
		}
	} else {
		l = utf8_len;
	}

	if (f > utf8_len) {
		RETURN_FALSE;
	} else if (f < 0 && -f > utf8_len) {
		f = 0;
	}

	if (l < 0 && (l + utf8_len - f) < 0) {
		RETURN_FALSE;
	}

	/* if "from" position is negative, count start position from the end
	 * of the string
	 */
	if (f < 0) {
		f = utf8_len + f;
		if (f < 0) {
			f = 0;
		}
	}

	/* if "length" position is negative, set it to the length
	 * needed to stop that many chars from the end of the string
	 */
	if (l < 0) {
		l = (utf8_len - f) + l;
		if (l < 0) {
			l = 0;
		}
	}

	if (f >= utf8_len) {
		RETURN_FALSE;
	}

	if ((f + l) > utf8_len) {
		l = utf8_len - f;
	}

	result = utf8_substr(str, f, l, &valid);

	RETURN_STRING((char*)result, 0);
}
/* }}} utf8_substr */

/* {{{ proto int utf8_strpos(string haystack , mixed needle [, int offset = 0])
   */
PHP_FUNCTION(utf8_strpos)
{
	zval     *needle;
	char     *haystack;
	char     *found = NULL;
	char8_t  *needle_char;
	long      offset = 0;
	long      offset_bytes = 0;
	int       haystack_len;
	int       haystack_utf8_len;
	zend_bool valid;
	long      tmp_result = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "sz|l", &haystack, &haystack_len, &needle, &offset) == FAILURE) {
		return;
	}

	haystack_utf8_len = utf8_strlen((char8_t*)haystack, &valid);

	if (!valid) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "Haystack does not contain valid UTF-8");
		return;
	}

	if (offset < 0 || offset > haystack_utf8_len) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "Offset not contained in string");
		RETURN_FALSE;
	}

	if (offset != 0) {
		offset_bytes = utf8_get_next_n_chars_length((char8_t*)haystack, offset, &valid);
	}

	if (Z_TYPE_P(needle) == IS_STRING) {
		if (!Z_STRLEN_P(needle)) {
			php_error_docref(NULL TSRMLS_CC, E_WARNING, "Empty needle");
			RETURN_FALSE;
		}

		valid = utf8_is_valid((char8_t*)Z_STRVAL_P(needle), Z_STRLEN_P(needle));

		if (!valid) {
			php_error_docref(NULL TSRMLS_CC, E_WARNING, "Needle does not contain valid UTF-8");
			return;
		}

		found = php_memnstr(haystack + offset_bytes,
			                Z_STRVAL_P(needle),
			                Z_STRLEN_P(needle),
			                haystack + haystack_len);
	} else {
		if (utf8_needle_char(needle, &needle_char TSRMLS_CC) != SUCCESS) {
			RETURN_FALSE;
		}

		found = php_memnstr(haystack + offset_bytes,
							(char*)needle_char,
							strlen((char*)needle_char),
		                    haystack + haystack_len);

		efree(needle_char);
	}

	if (found) {
		tmp_result = utf8_strlen_maxbytes((char8_t*)haystack, found - haystack, &valid);

		if (!valid) {
			php_error_docref(NULL TSRMLS_CC, E_RECOVERABLE_ERROR, "Could not calculate result.");
			return;
		}

		RETURN_LONG(tmp_result);
	}

	RETURN_FALSE;
}
/* }}} utf8_str_strpos */

/* {{{ proto int utf8_strrpos(string haystack , mixed needle [, int offset = 0])
   */
PHP_FUNCTION(utf8_strrpos)
{
	zval     *zneedle;
	char8_t  *needle;
	char     *haystack;
	int       needle_len, haystack_len;
	long      offset = 0;
	char     *p, *e;
	int       haystack_utf8_len, offset_bytes = 0;
	zend_bool valid;
	char     *found;
	long      tmp_result = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "sz|l", &haystack, &haystack_len, &zneedle, &offset) == FAILURE) {
		RETURN_FALSE;
	}

	haystack_utf8_len = utf8_strlen((char8_t*)haystack, &valid);

	if (!valid) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "Haystack does not contain valid UTF-8");
		return;
	}

	if (offset >= 0) {
		if (offset > haystack_utf8_len) {
			php_error_docref(NULL TSRMLS_CC, E_WARNING, "Offset is greater than the length of haystack string");
			RETURN_FALSE;
		}
	} else {
		if (offset < -INT_MAX || -offset > haystack_utf8_len) {
			php_error_docref(NULL TSRMLS_CC, E_WARNING, "Offset is greater than the length of haystack string");
			RETURN_FALSE;
		}
	}

	if (Z_TYPE_P(zneedle) == IS_STRING) {
		needle = (char8_t*)Z_STRVAL_P(zneedle);
		needle_len = Z_STRLEN_P(zneedle);

		valid = utf8_is_valid((char8_t*)needle, needle_len);

		if (!valid) {
			php_error_docref(NULL TSRMLS_CC, E_WARNING, "Needle does not contain valid UTF-8");
			return;
		}
	} else {
		if (utf8_needle_char(zneedle, &needle TSRMLS_CC) != SUCCESS) {
			RETURN_FALSE;
		}

		needle_len = strlen((char*)needle);
	}

	if ((haystack_len == 0) || (needle_len == 0)) {
		RETURN_FALSE;
	}

	if (offset >= 0) {
		if (offset != 0) {
			offset_bytes = utf8_get_next_n_chars_length((char8_t*)haystack, offset, &valid);
		}

		p = haystack + offset_bytes;
		e = haystack + haystack_len - needle_len;
	} else {
		offset_bytes = utf8_get_next_n_chars_length((char8_t*)haystack, haystack_utf8_len + offset, &valid);
		offset_bytes = (haystack_len - offset_bytes) * -1;

		p = haystack;
		if (needle_len > -offset_bytes) {
			e = haystack + haystack_len - needle_len;
		} else {
			e = haystack + haystack_len + offset_bytes - 1;
		}
	}

	if (needle_len == 1) {
		/* Single character search can shortcut memcmps */
		while (e >= p) {
			if (*e == *needle) {
				found = e;
				break;
			}
			e--;
		}
	} else {
		while (e >= p) {
			if (memcmp(e, needle, needle_len) == 0) {
				found = e;
				break;
			}
			e--;
		}
	}

	if (found) {
		tmp_result = utf8_strlen_maxbytes((char8_t*)haystack, found - p + (offset > 0 ? offset_bytes : 0), &valid);

		if (!valid) {
			php_error_docref(NULL TSRMLS_CC, E_RECOVERABLE_ERROR, "Could not calculate result.");
			return;
		}

		RETVAL_LONG(tmp_result);
	} else {
		RETVAL_FALSE;
	}

	if (Z_TYPE_P(zneedle) != IS_STRING) {
		efree(needle);
	}
}
/* }}} utf8_str_strrpos */

/* {{{ proto array utf8_str_split(string str [, int split_length])
   */
PHP_FUNCTION(utf8_str_split)
{
	char8_t   *str;
	int       str_len;
	size_t    utf8_len;
	long      split_length = 1;
	zend_bool valid = 0;
	int       n_reg_segments, bytes;
	char8_t  *p;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s|l", &str, &str_len, &split_length) == FAILURE) {
		return;
	}

	if (split_length <= 0) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "The length of each segment must be greater than zero");
		return;
	}

	utf8_len = utf8_strlen(str, &valid);

	if (!valid) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "String does not contain valid UTF-8");
		RETURN_FALSE;
	}

	array_init_size(return_value, ((utf8_len - 1) / split_length) + 1);

	if (split_length >= utf8_len) {
		add_next_index_stringl(return_value, (char*)str, str_len, 1);
		return;
	}

	n_reg_segments = utf8_len / split_length;
	p = str;

	while (n_reg_segments-- > 0) {
		bytes = utf8_get_next_n_chars_length(p, split_length, &valid);
		add_next_index_stringl(return_value, (char*)p, bytes, 1);
		p += bytes;
	}

	if (p != (str + str_len)) {
		add_next_index_stringl(return_value, (char*)p, (str + str_len - p), 1);
	}
}
/* }}} utf8_str_split */

/* {{{ proto string utf8_strrev(string str)
   */
PHP_FUNCTION(utf8_strrev)
{
	char     *str, *result;
	char     *scanl, *scanr, *scanr2, c;
	int       str_len;
	zend_bool valid;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	if (str_len == 0) {
		RETURN_STRINGL(str, str_len, 1);
	}

	/* This code assumes that str is valid UTF-8 so we check */
	valid = utf8_is_valid((uint8_t*)str, str_len);

	if (!valid) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "String does not contain valid UTF-8");
		RETURN_FALSE;
	}

	result = emalloc(str_len + 1);
	/* We reverse the string in memory so we copy it beforehand */
	strcpy(result, str);

    /* first reverse the string */
    for (scanl = result, scanr= result + str_len; scanl < scanr;)
        c= *scanl, *scanl++= *--scanr, *scanr= c;

    /* then scan all bytes and reverse each multibyte character */
    for (scanl = scanr = result; (c = *scanr++);) {
        if ( (c & 0x80) == 0) // ASCII char
            scanl = scanr;
        else if ( (c & 0xc0) == 0xc0 ) { // start of multibyte
            scanr2 = scanr;
            switch (scanr - scanl) {
                case 4: c = *scanl, *scanl++ = *--scanr, *scanr = c; // fallthrough
                case 3: // fallthrough
                case 2: c = *scanl, *scanl++ = *--scanr, *scanr = c;
            }
            scanr= scanl= scanr2;
        }
    }

	RETURN_STRINGL(result, str_len, 0);
}
/* }}} utf8_strrev */

/* {{{ proto string utf8_recover(string str)
   */
PHP_FUNCTION(utf8_recover)
{
	char8_t *str, *result;
	int   str_len = 0, result_len;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	result = utf8_recover(str, str_len, &result_len);

	RETURN_STRINGL((char*)result, result_len, 0);
}
/* }}} utf8_recover */

/* {{{ proto string utf8_chr(int code)
   */
PHP_FUNCTION(utf8_chr)
{
	long     c;
	char8_t *string;

	if (zend_parse_parameters_ex(ZEND_PARSE_PARAMS_QUIET, ZEND_NUM_ARGS() TSRMLS_CC, "l", &c) == FAILURE) {
		return;
	}

	string = utf8_char_from_codepoint((uint32_t)c);

	RETURN_STRING((char*)string, 0);
}
/* }}} utf8_chr */

/* {{{ proto int utf8_ord(string str)
   */
PHP_FUNCTION(utf8_ord)
{
	char8_t  *str = NULL;
	int       str_len = 0;
	zend_bool valid;
	uint32_t  codepoint;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	if (str_len == 0) {
		RETURN_LONG(0);
	}

	codepoint = utf8_ord(str, &valid);

	if (!valid) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "String does not contain valid UTF-8");
		return;
	}

	RETURN_LONG(codepoint);
}
/* }}} utf8_ord */

/* {{{ proto bool utf8_has_bom(string str)
   */
PHP_FUNCTION(utf8_has_bom)
{
	char8_t  *str = NULL;
	char8_t   maybe_bom[4];
	int       str_len = 0;
	zend_bool result;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	if (str_len <= 2) {
		RETURN_FALSE;
	}

	/*
 	 * Inspired by microutf8 from Tomasz Konojacki
	 */
	strncpy((char*)maybe_bom, (char*)str, 3);
	maybe_bom[3] = '\0';
	if (strcmp((char*)maybe_bom, (char*)(char8_t*)"\xEF\xBB\xBF") == 0) {
		RETURN_TRUE;
	}

	RETURN_FALSE;
}
/* }}} utf8_has_bom */

/* {{{ proto bool string_is_ascii(string str)
   */
PHP_FUNCTION(string_is_ascii)
{
	unsigned char *str = NULL;
	int   str_len = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	while (*str) {
		if (*str++ > 0x7f) {
			RETURN_FALSE;
		}
	}

	RETURN_TRUE;
}
/* }}} string_is_ascii */

/* {{{ proto string strip_non_ascii(string str)
   */
PHP_FUNCTION(strip_non_ascii)
{
	char *str, *result, *begin;
	int str_len = 0, result_len = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	if (str_len == 0) {
		RETURN_STRINGL(str, 0, 1);
	}

	result = (char*) emalloc(str_len + 1);
	begin = result;

	while (*str) {
		if ((unsigned char)*str <= 0x7f) {
			*result++ = *str;
			result_len++;
		}
		*str++;
	}
	*result = '\0';

	if (result_len != str_len) {
		begin = (char*) erealloc(begin, (result_len + 1));
	}

	RETURN_STRINGL(begin, result_len, 0);
}
/* }}} strip_non_ascii */

/* {{{ proto string utf8_encode2(string str)
   */
PHP_FUNCTION(utf8_encode2)
{
	char    *str;
	int      str_len = 0, result_len = 0;
	char8_t *result;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	windows1252_to_utf8(str, str_len, &result, &result_len);

	RETURN_STRINGL((char*)result, result_len, 0);
}
/* }}} utf8_encode2 */

/* {{{ proto string utf8_decode2(string str)
   */
PHP_FUNCTION(utf8_decode2)
{
	char8_t *str;
	char    *result;
	int      str_len = 0, result_len = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	utf8_to_windows1252(str, str_len, &result, &result_len);

	RETURN_STRINGL(result, result_len, 0);
}
/* }}} utf8_decode2 */

#endif /* HAVE_UTF8 */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
