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
	PHP_FE(utf8_str_split      , utf8_str_split_arg_info)
	PHP_FE(utf8_chr            , utf8_chr_arg_info)
	PHP_FE(utf8_ord            , utf8_ord_arg_info)
	PHP_FE(utf8_recover        , utf8_recover_arg_info)
	PHP_FE(utf8_has_bom        , utf8_has_bom_arg_info)
	PHP_FE(string_is_ascii     , string_is_ascii_arg_info)
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


/* {{{ proto bool utf8_is_valid(string str)
   */
PHP_FUNCTION(utf8_is_valid)
{
	unsigned char *str = NULL;
	int str_len = 0;
	int valid = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	if (str_len == 0) {
		RETURN_TRUE;
	}

	valid = utf8_is_valid(str);

	RETURN_BOOL(valid);
}
/* }}} utf8_is_valid */


/* {{{ proto int utf8_strlen(string str)
   */
PHP_FUNCTION(utf8_strlen)
{
	unsigned char *str = NULL;
	int str_len = 0;
	int valid = 0;
	size_t count;

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
	unsigned char *str = NULL;
	char *result = NULL;
	int str_len = 0;
	int utf8_len = 0;
	int valid = 0;
	long l = 0, f;
	int argc = ZEND_NUM_ARGS();

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

	RETURN_STRING(result, 0);
}
/* }}} utf8_substr */

/* {{{ proto array utf8_str_split(string str [, int split_length])
   */
PHP_FUNCTION(utf8_str_split)
{
	char *str;
	int str_len;
	size_t utf8_len;
	long split_length = 1;
	int valid = 0;
	int n_reg_segments;
	char *p;
	int bytes;

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
		add_next_index_stringl(return_value, str, str_len, 1);
		return;
	}

	n_reg_segments = utf8_len / split_length;
	p = str;

	while (n_reg_segments-- > 0) {
		bytes = utf8_get_next_n_chars_length(p, split_length, &valid);
		add_next_index_stringl(return_value, p, bytes, 1);
		p += bytes;
	}

	if (p != (str + str_len)) {
		add_next_index_stringl(return_value, p, (str + str_len - p), 1);
	}
}
/* }}} utf8_str_split */

/* {{{ proto string utf8_recover(string str)
   */
PHP_FUNCTION(utf8_recover)
{
	unsigned char *str = NULL;
	int str_len = 0;
	char *result = NULL;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	result = utf8_recover(str, str_len);

	RETURN_STRING(result, 0);
}
/* }}} utf8_recover */

/* {{{ proto string utf8_chr(int code)
   */
PHP_FUNCTION(utf8_chr)
{
	long c;
	char* string;

	if (zend_parse_parameters_ex(ZEND_PARSE_PARAMS_QUIET, ZEND_NUM_ARGS() TSRMLS_CC, "l", &c) == FAILURE) {
		return;
	}

	string = utf8_char_from_codepoint((uint32_t)c);

	RETURN_STRING(string, 0);
}
/* }}} utf8_ord */

/* {{{ proto int utf8_ord(string str)
   */
PHP_FUNCTION(utf8_ord)
{
	unsigned char *str = NULL;
	int str_len = 0;
	int valid = 0;
	uint32_t codepoint;

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
	const char *str = NULL;
	int str_len = 0;
	int result = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	result = utf8_has_bom(str);

	RETURN_BOOL(result);
}
/* }}} utf8_has_bom */

/* {{{ proto bool string_is_ascii(string str)
   */
PHP_FUNCTION(string_is_ascii)
{
	const char *str = NULL;
	int i;
	int str_len = 0;
	int tmp;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &str, &str_len) == FAILURE) {
		return;
	}

	for (i = 0; i < str_len; i++) {
		tmp = (unsigned char) str[i];
		if (tmp > 127) {
			RETURN_FALSE;
		}
	}

	RETURN_TRUE;
}
/* }}} string_is_ascii */

#endif /* HAVE_UTF8 */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
