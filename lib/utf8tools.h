/*
 * Copyright (c) 2008-2010 Bjoern Hoehrmann <bjoern@hoehrmann.de>
 * See http://bjoern.hoehrmann.de/utf-8/decoder/dfa/ for details.
 */

#include <stdint.h>
#include <stdlib.h>
#include "zend.h"

int utf8_is_valid(const uint8_t *s, int length_bytes);
size_t utf8_strlen(const uint8_t *s, int *valid);
int utf8_has_bom(const uint8_t *s, int str_len);
char* utf8_substr(const uint8_t *s, int start, int len, int *valid);
uint32_t utf8_ord(const uint8_t *s, int *valid);
int utf8_get_next_n_chars_length(const uint8_t *s, int n, int *valid);
char* utf8_recover(const uint8_t *s, int length_bytes);
char* utf8_char_from_codepoint(uint32_t codepoint);
size_t utf8_strlen_maxbytes(const uint8_t *s, long max_bytes, int *valid);
void windows1252_to_utf8(const char* str, int str_len, uint8_t **result_str, int *result_len);
