/*
 * Copyright (c) 2008-2010 Bjoern Hoehrmann <bjoern@hoehrmann.de>
 * See http://bjoern.hoehrmann.de/utf-8/decoder/dfa/ for details.
 */

#ifndef PHP_UTF8_TOOLS_H
#define PHP_UTF8_TOOLS_H

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#ifdef HAVE_UTF8

#ifdef  __cplusplus
extern "C" {
#endif

#include <stdint.h>
#include <stdlib.h>
#include "zend.h"

typedef uint8_t char8_t;

#ifdef PHP_WIN32
#define UTF8_API __declspec(dllexport)
#else
#define UTF8_API
#endif

/* Check whether the given string is valid UTF-8 */
UTF8_API zend_bool utf8_is_valid(const char8_t *s, int length_bytes);

/* Get the number of codepoints of the given string */
UTF8_API size_t utf8_strlen(const char8_t *s, zend_bool *valid);

/* Returns a new string based on the codepoint start and the number of codepoints len.
	Returned string has to be freed by the caller */
UTF8_API char8_t* utf8_substr(const char8_t *s, int start, int len, zend_bool *valid);

/* Get the first codepoint from the given string */
UTF8_API uint32_t utf8_ord(const char8_t *s, zend_bool *valid);

/* Get the size in bytes of the first n codepoints from the given string */
UTF8_API int utf8_get_next_n_chars_length(const char8_t *s, int n, zend_bool *valid);

/* Turns an invalid UTF-8 string into a valid one by replacing invalid sequences with the unicode replacement character
	Returned string has to be freed by the caller */
UTF8_API char8_t* utf8_recover(const char8_t *s, int length_bytes, int *result_len);

/* Get the string representation of the given codepoint.
	Returned string has to be freed by the caller */
UTF8_API char8_t* utf8_char_from_codepoint(uint32_t codepoint);

/* Returns many complete codepoints are contained in the first max_bytes bytes */
UTF8_API size_t utf8_strlen_maxbytes(const char8_t *s, long max_bytes, zend_bool *valid);

/* Converts a Windows-1252 encoded string into an UTF-8 encoded string.
	result_str has to be freed by the caller */
UTF8_API void windows1252_to_utf8(const char *str, int str_len, uint8_t **result_str, int *result_len);

/* Converts a UTF-8 encoded string into an Windows-1252 encoded string.
	Codepoints that are invalid or can't be represented are replaced with a question mark.
	result_str has to be freed by the caller */
UTF8_API void utf8_to_windows1252(const char8_t *str, int str_len, char **result_str, int *result_len);

#ifdef  __cplusplus
} // extern "C"
#endif

#endif /* PHP_HAVE_UTF8 */

#endif /* PHP_UTF8_TOOLS_H */
