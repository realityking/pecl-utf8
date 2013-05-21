#include "utf8tools.h"

#include <string.h>

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
decode(uint32_t* state, uint32_t* codep, uint32_t byte)
{
	uint32_t type = utf8d[byte];

	*codep = (*state != UTF8_ACCEPT) ?
		(byte & 0x3fu) | (*codep << 6) :
		(0xff >> type) & (byte);

	*state = utf8d[256 + *state + type];
	return *state;
}

size_t
utf8_strlen(const uint8_t* s, int *valid)
{
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
utf8_has_bom(const uint8_t *s, int str_len)
{
	uint8_t maybe_bom[4];
	if (str_len <= 2)
		return 0;

	strncpy((char*)maybe_bom, (char*)s, 3);
	maybe_bom[3] = 0;
	if (strcmp((char*)maybe_bom, (char*)(uint8_t*)UTF8_BOM) == 0)
		return 1;
	else
		return 0;
}

/*
 * Author: Mikko Lehtonen
 * See: https://github.com/scoopr/wtf8/blob/master/wtf8.h
 */
static inline char* utf8_encode(uint32_t codepoint, char* str)
{
	unsigned char* ustr = (unsigned char*)str;
	if (codepoint <= 0x7f) {
		ustr[0] = (unsigned char)codepoint;
		ustr+=1;
	} else if (codepoint <= 0x7ff ) {
		ustr[0] = (unsigned char) (0xc0 + (codepoint >> 6));
		ustr[1] = (unsigned char) (0x80 + (codepoint & 0x3f));
		ustr+=2;
	} else if (codepoint <= 0xffff) {
		ustr[0] = (unsigned char) (0xe0 + (codepoint >> 12));
		ustr[1] = (unsigned char) (0x80 + ((codepoint >> 6) & 63));
		ustr[2] = (unsigned char) (0x80 + (codepoint & 63));
		ustr+=3;
	} else if (codepoint <= 0x1ffff) {
		ustr[0] = (unsigned char) (0xf0 + (codepoint >> 18));
		ustr[1] = (unsigned char) (0x80 + ((codepoint >> 12) & 0x3f));
		ustr[2] = (unsigned char) (0x80 + ((codepoint >> 6) & 0x3f));
		ustr[3] = (unsigned char) (0x80 + (codepoint & 0x3f));
		ustr+=4;
	}

	return (char*)ustr;
}

/*
 * Author: Rouven Weßling
 * License: PHP License 3.01
 */
int
utf8_is_valid(const uint8_t* s, int length_bytes)
{
	uint32_t codepoint;
	uint32_t state = UTF8_ACCEPT;
	int i;

	for (i = 0; i <= length_bytes; i++) {
		decode(&state, &codepoint, *s++);
		if (state == UTF8_REJECT) {
			return 0;
		}
	}

	return state == UTF8_ACCEPT;
}

char*
utf8_substr(const uint8_t *s, int start, int len, int *valid)
{
	uint32_t codepoint;
	uint32_t state = UTF8_ACCEPT;
	int start_bytes = 0;
	int length_bytes = 0;
	const uint8_t *str_start = s;
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
utf8_ord(const uint8_t* s, int *valid)
{
	uint32_t codepoint;
	uint32_t state = UTF8_ACCEPT;

	for (; *s; ++s)
		if (!decode(&state, &codepoint, *s))
			break;

	*valid = (state == UTF8_ACCEPT);

	return codepoint;
}

int
utf8_get_next_n_chars_length(const uint8_t* s, int n, int *valid)
{
	uint32_t codepoint;
	uint32_t state = UTF8_ACCEPT;
	int bytes = 0;

	for (int count = 0; *s; ++s) {
		if (count == n) {
			break;
		}
		if (!decode(&state, &codepoint, *s)) {
			count += 1;
		}
		bytes += 1;
	}

	*valid = (state == UTF8_ACCEPT);

	return bytes;
}

char*
utf8_char_from_codepoint(uint32_t codepoint)
{
	char *out, *begin;

	out = ecalloc(5, sizeof(char));
	begin = out;
	out = utf8_encode(codepoint, out);
	out[0] = '\0';

	return begin;
}

char*
utf8_recover(const uint8_t* s, int length_bytes)
{
	uint32_t codepoint;
	uint32_t prev, current;
	int i;
	char *out, *begin;

	/* There's probably a way to save some memory here */
	out = ecalloc(3 * length_bytes, sizeof(char));

	begin = out;

	for (prev = 0, current = 0, i = 0; i <= length_bytes; prev = current, s++, i++) {

		switch (decode(&current, &codepoint, *s)) {
			case UTF8_ACCEPT:
				/* Confirm that this doesn't cause other issues */
				if (codepoint != 0x0000) {
					out = utf8_encode(codepoint, out);
				}
				break;
			case UTF8_REJECT:
				out[0] = 0xef;
				out[1] = 0xbf;
				out[2] = 0xbd;
				out+=3;
				current = UTF8_ACCEPT;
				if (prev != UTF8_ACCEPT) {
					s--;
					i--;
				}
				break;
		}
	}

	out[0] = '\0';

	return begin;
}

void
utf8_strrev(char *str, long str_len, char *target)
{
	/* this assumes that str is valid UTF-8 */
	char *scanl, *scanr, *scanr2, c;
	int i;

	/* first reverse the string into the target */
	for (i = 0, scanr = str + str_len; i < str_len; ++i) {
		target[i] = *--scanr;
	}
	target[i+1] = '\0';

    /* then scan all bytes and reverse each multibyte character */
    for (scanl = scanr = target; (c = *scanr++);) {
        if ( (c & 0x80) == 0) // ASCII char
            scanl= scanr;
        else if ( (c & 0xc0) == 0xc0 ) { // start of multibyte
            scanr2= scanr;
            switch (scanr - scanl) {
                case 4: c= *scanl, *scanl++= *--scanr, *scanr= c; // fallthrough
                case 3: // fallthrough
                case 2: c= *scanl, *scanl++= *--scanr, *scanr= c;
            }
            scanr= scanl= scanr2;
        }
    }
}

size_t
utf8_strlen_maxbytes(const uint8_t* s, long max_bytes, int *valid)
{
	uint32_t codepoint;
	uint32_t state = UTF8_ACCEPT;
	size_t count;
	int bytes;

	for (bytes = 0, count = 0; *s; ++s) {
		if (bytes == max_bytes) {
			break;
		}
		if (!decode(&state, &codepoint, *s)) {
			count += 1;
		}
		bytes += 1;
	}

	*valid = (state == UTF8_ACCEPT);

	return count;
}
