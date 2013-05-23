/*
 * Copyright (c) 2008-2010 Bjoern Hoehrmann <bjoern@hoehrmann.de>
 * See http://bjoern.hoehrmann.de/utf-8/decoder/dfa/ for details.
 */

#include <stdint.h>
#include <stdlib.h>
#include "zend.h"

zend_bool utf8_is_valid(const uint8_t *s, int length_bytes);
size_t utf8_strlen(const uint8_t *s, zend_bool *valid);
zend_bool utf8_has_bom(const uint8_t *s, int str_len);
char* utf8_substr(const uint8_t *s, int start, int len, zend_bool *valid);
uint32_t utf8_ord(const uint8_t *s, zend_bool *valid);
int utf8_get_next_n_chars_length(const uint8_t *s, int n, zend_bool *valid);
char* utf8_recover(const uint8_t *s, int length_bytes);
char* utf8_char_from_codepoint(uint32_t codepoint);
size_t utf8_strlen_maxbytes(const uint8_t *s, long max_bytes, zend_bool *valid);
void windows1252_to_utf8(const char* str, int str_len, uint8_t **result_str, int *result_len);
void utf8_to_windows1252(const uint8_t *str, int str_len, char **result_str, int *result_len);
