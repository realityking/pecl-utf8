#include "utf8tools.h"

#include <string.h>
#include "zend.h"

/*
 * Copyright (c) 2008-2010 Bjoern Hoehrmann <bjoern@hoehrmann.de>
 * See http://bjoern.hoehrmann.de/utf-8/decoder/dfa/ for details.
 */

#define UTF8_ACCEPT 0
#define UTF8_REJECT 12

static const uint8_t utf8d[] = {
  /*
   * The first part of the table maps bytes to character classes that
   * to reduce the size of the transition table and create bitmasks.
   */
   0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,  0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
   0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,  0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
   0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,  0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
   0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,  0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
   1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,  9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,
   7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,  7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,
   8,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,  2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,
  10,3,3,3,3,3,3,3,3,3,3,3,3,4,3,3, 11,6,6,6,5,8,8,8,8,8,8,8,8,8,8,8,

  /*
   * The second part is a transition table that maps a combination
   * of a state of the automaton and a character class to a state.
   */
   0,12,24,36,60,96,84,12,12,12,48,72, 12,12,12,12,12,12,12,12,12,12,12,12,
  12, 0,12,12,12,12,12, 0,12, 0,12,12, 12,24,12,12,12,12,12,24,12,24,12,12,
  12,12,12,12,12,12,12,24,12,12,12,12, 12,24,12,12,12,12,12,12,12,24,12,12,
  12,12,12,12,12,12,12,36,12,36,12,12, 12,36,12,12,12,12,12,36,12,36,12,12,
  12,36,12,12,12,12,12,12,12,12,12,12,
};

uint32_t inline
decode(uint32_t* state, uint32_t* codep, uint32_t byte) {
  uint32_t type = utf8d[byte];

  *codep = (*state != UTF8_ACCEPT) ?
	(byte & 0x3fu) | (*codep << 6) :
	(0xff >> type) & (byte);

  *state = utf8d[256 + *state + type];
  return *state;
}

size_t
utf8_strlen(uint8_t* s, int *valid) {
	uint32_t codepoint;
	uint32_t state = UTF8_ACCEPT;
	size_t count;

	for (count = 0; *s; ++s)
		if (!decode(&state, &codepoint, *s))
			count += 1;

	*valid = (state == UTF8_ACCEPT);

	return count;
}

/*
 * Functions inspired by microutf8 from Tomasz Konojacki
 */
#define UTF8_BOM "\xEF\xBB\xBF" /* note that it need to be casted to uint8_t* */

int
utf8_has_bom(uint8_t *s)
{
	uint8_t maybe_bom[4];
	if (strlen(s) <= 2)
		return 0;

	strncpy(maybe_bom, s, 3);
	maybe_bom[3] = 0;
	if (strcmp(maybe_bom, (uint8_t*)UTF8_BOM) == 0)
		return 1;
	else
		return 0;
}

/*
 * Author: Rouven Weßling
 * License: PHP License 3.01
 */
int
utf8_is_valid(uint8_t* s) {
	uint32_t codepoint;
	uint32_t state = UTF8_ACCEPT;

	for (; *s; ++s)
		decode(&state, &codepoint, *s);

	return state == UTF8_ACCEPT;
}

char*
utf8_substr(uint8_t *s, int start, int len, int *valid) {
	uint32_t codepoint;
	uint32_t state = UTF8_ACCEPT;
	int start_bytes = 0;
	int length_bytes = 0;
	uint8_t *str_start = s;
	char *out;

	for (int count = 0; *s; ++s) {
		if (count == start) {
			break;
		}
		if (!decode(&state, &codepoint, *s)) {
			count += 1;
		}
		start_bytes += 1;
	}

	for (int count = 0; *s; ++s) {
		if (count == len) {
			break;
		}
		if (!decode(&state, &codepoint, *s)) {
			count += 1;
		}
		length_bytes += 1;
	}

	out = ecalloc(length_bytes + 1, sizeof(char));
	memcpy(out, str_start + start_bytes, length_bytes);
	out[length_bytes] = '\0';

	*valid = (state == UTF8_ACCEPT);

	return out;
}

uint32_t
utf8_ord(uint8_t* s, int *valid) {
	uint32_t codepoint;
	uint32_t state = UTF8_ACCEPT;

	for (; *s; ++s)
		if (!decode(&state, &codepoint, *s))
			break;

	*valid = (state == UTF8_ACCEPT);

	return codepoint;
}
