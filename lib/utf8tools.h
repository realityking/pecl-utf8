/*
 * Copyright (c) 2008-2010 Bjoern Hoehrmann <bjoern@hoehrmann.de>
 * See http://bjoern.hoehrmann.de/utf-8/decoder/dfa/ for details.
 */

#include <stdint.h>
#include <stdlib.h>

int utf8_is_valid(uint8_t* s);
size_t utf8_strlen(uint8_t* s, int *valid);
int utf8_has_bom(uint8_t *s);
char* utf8_substr(uint8_t* s, int start, int len, int *valid);
