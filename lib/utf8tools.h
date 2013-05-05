/*
 * Copyright (c) 2008-2010 Bjoern Hoehrmann <bjoern@hoehrmann.de>
 * See http://bjoern.hoehrmann.de/utf-8/decoder/dfa/ for details.
 */

#include <stdint.h>
#include <stdlib.h>
#include "zend.h"

int utf8_is_valid(uint8_t* s, int length_bytes);
size_t utf8_strlen(uint8_t* s, int *valid);
int utf8_has_bom(uint8_t *s, int str_len);
char* utf8_substr(uint8_t* s, int start, int len, int *valid);
uint32_t utf8_ord(uint8_t* s, int *valid);
int utf8_get_next_n_chars_length(uint8_t* s, int n, int *valid);
char* utf8_recover(uint8_t* s, int length_bytes);
char* utf8_char_from_codepoint(uint32_t codepoint);
void utf8_strrev(char *str, long str_len);
