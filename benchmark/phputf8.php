<?php

namespace phputf8;

function strlen($str)
{
    return \strlen(\utf8_decode($str));
}

function string_is_ascii($str) {
    // Search for any bytes which are outside the ASCII range...
    return (\preg_match('/(?:[^\x00-\x7F])/', $str) !== 1);
}

function substr($str, $offset, $length = NULL)
{

    // generates E_NOTICE
    // for PHP4 objects, but not PHP5 objects
    $str = (string)$str;
    $offset = (int)$offset;
    if (!\is_null($length)) $length = (int)$length;

    // handle trivial cases
    if ($length === 0) return '';
    if ($offset < 0 && $length < 0 && $length < $offset)
        return '';

    // normalise negative offsets (we could use a tail
    // anchored pattern, but they are horribly slow!)
    if ($offset < 0) {

        // see notes
        $strlen = \strlen(\utf8_decode($str));
        $offset = $strlen + $offset;
        if ($offset < 0) $offset = 0;

    }

    $Op = '';
    $Lp = '';

    // establish a pattern for offset, a
    // non-captured group equal in length to offset
    if ($offset > 0) {

        $Ox = (int)($offset/65535);
        $Oy = $offset%65535;

        if ($Ox) {
            $Op = '(?:.{65535}){'.$Ox.'}';
        }

        $Op = '^(?:'.$Op.'.{'.$Oy.'})';

    } else {

        // offset == 0; just anchor the pattern
        $Op = '^';

    }

    // establish a pattern for length
    if (\is_null($length)) {

        // the rest of the string
        $Lp = '(.*)$';

    } else {

        if (!isset($strlen)) {
            // see notes
            $strlen = \strlen(\utf8_decode($str));
        }

        // another trivial case
        if ($offset > $strlen) return '';

        if ($length > 0) {

            // reduce any length that would
            // go passed the end of the string
            $length = \min($strlen-$offset, $length);

            $Lx = (int)( $length / 65535 );
            $Ly = $length % 65535;

            // negative length requires a captured group
            // of length characters
            if ($Lx) $Lp = '(?:.{65535}){'.$Lx.'}';
            $Lp = '('.$Lp.'.{'.$Ly.'})';

        } else if ($length < 0) {

            if ( $length < ($offset - $strlen) ) {
                return '';
            }

            $Lx = (int)((-$length)/65535);
            $Ly = (-$length)%65535;

            // negative length requires ... capture everything
            // except a group of  -length characters
            // anchored at the tail-end of the string
            if ($Lx) $Lp = '(?:.{65535}){'.$Lx.'}';
            $Lp = '(.*)(?:'.$Lp.'.{'.$Ly.'})$';

        }

    }

    if (!\preg_match( '#'.$Op.$Lp.'#us',$str, $match )) {
        return '';
    }

    return $match[1];
}

function utf8_is_valid($str) {

    $mState = 0;     // cached expected number of octets after the current octet
                     // until the beginning of the next UTF8 character sequence
    $mUcs4  = 0;     // cached Unicode character
    $mBytes = 1;     // cached expected number of octets in the current sequence

    $len = \strlen($str);

    for($i = 0; $i < $len; $i++) {

        $in = \ord($str{$i});

        if ( $mState == 0) {

            // When mState is zero we expect either a US-ASCII character or a
            // multi-octet sequence.
            if (0 == (0x80 & ($in))) {
                // US-ASCII, pass straight through.
                $mBytes = 1;

            } else if (0xC0 == (0xE0 & ($in))) {
                // First octet of 2 octet sequence
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 0x1F) << 6;
                $mState = 1;
                $mBytes = 2;

            } else if (0xE0 == (0xF0 & ($in))) {
                // First octet of 3 octet sequence
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 0x0F) << 12;
                $mState = 2;
                $mBytes = 3;

            } else if (0xF0 == (0xF8 & ($in))) {
                // First octet of 4 octet sequence
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 0x07) << 18;
                $mState = 3;
                $mBytes = 4;

            } else if (0xF8 == (0xFC & ($in))) {
                /* First octet of 5 octet sequence.
                *
                * This is illegal because the encoded codepoint must be either
                * (a) not the shortest form or
                * (b) outside the Unicode range of 0-0x10FFFF.
                * Rather than trying to resynchronize, we will carry on until the end
                * of the sequence and let the later error handling code catch it.
                */
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 0x03) << 24;
                $mState = 4;
                $mBytes = 5;

            } else if (0xFC == (0xFE & ($in))) {
                // First octet of 6 octet sequence, see comments for 5 octet sequence.
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 1) << 30;
                $mState = 5;
                $mBytes = 6;

            } else {
                /* Current octet is neither in the US-ASCII range nor a legal first
                 * octet of a multi-octet sequence.
                 */
                return FALSE;

            }

        } else {

            // When mState is non-zero, we expect a continuation of the multi-octet
            // sequence
            if (0x80 == (0xC0 & ($in))) {

                // Legal continuation.
                $shift = ($mState - 1) * 6;
                $tmp = $in;
                $tmp = ($tmp & 0x0000003F) << $shift;
                $mUcs4 |= $tmp;

                /**
                * End of the multi-octet sequence. mUcs4 now contains the final
                * Unicode codepoint to be output
                */
                if (0 == --$mState) {

                    /*
                    * Check for illegal sequences and codepoints.
                    */
                    // From Unicode 3.1, non-shortest form is illegal
                    if (((2 == $mBytes) && ($mUcs4 < 0x0080)) ||
                        ((3 == $mBytes) && ($mUcs4 < 0x0800)) ||
                        ((4 == $mBytes) && ($mUcs4 < 0x10000)) ||
                        (4 < $mBytes) ||
                        // From Unicode 3.2, surrogate characters are illegal
                        (($mUcs4 & 0xFFFFF800) == 0xD800) ||
                        // Codepoints outside the Unicode range are illegal
                        ($mUcs4 > 0x10FFFF)) {

                        return FALSE;

                    }

                    //initialize UTF8 cache
                    $mState = 0;
                    $mUcs4  = 0;
                    $mBytes = 1;
                }

            } else {
                /**
                *((0xC0 & (*in) != 0x80) && (mState != 0))
                * Incomplete multi-octet sequence.
                */

                return FALSE;
            }
        }
    }
    return TRUE;
}

function utf8_ord($chr)
{

    $ord0 = \ord($chr);

    if ( $ord0 >= 0 && $ord0 <= 127 ) {
        return $ord0;
    }

    if ( !isset($chr{1}) ) {
        \trigger_error('Short sequence - at least 2 bytes expected, only 1 seen');
        return FALSE;
    }

    $ord1 = \ord($chr{1});
    if ( $ord0 >= 192 && $ord0 <= 223 ) {
        return ( $ord0 - 192 ) * 64
            + ( $ord1 - 128 );
    }

    if ( !isset($chr{2}) ) {
        \trigger_error('Short sequence - at least 3 bytes expected, only 2 seen');
        return FALSE;
    }
    $ord2 = \ord($chr{2});
    if ( $ord0 >= 224 && $ord0 <= 239 ) {
        return ($ord0-224)*4096
            + ($ord1-128)*64
                + ($ord2-128);
    }

    if ( !isset($chr{3}) ) {
        \trigger_error('Short sequence - at least 4 bytes expected, only 3 seen');
        return FALSE;
    }
    $ord3 = \ord($chr{3});
    if ($ord0>=240 && $ord0<=247) {
        return ($ord0-240)*262144
            + ($ord1-128)*4096
                + ($ord2-128)*64
                    + ($ord3-128);

    }

    if ( !isset($chr{4}) ) {
        \trigger_error('Short sequence - at least 5 bytes expected, only 4 seen');
        return FALSE;
    }
    $ord4 = ord($chr{4});
    if ($ord0>=248 && $ord0<=251) {
        return ($ord0-248)*16777216
            + ($ord1-128)*262144
                + ($ord2-128)*4096
                    + ($ord3-128)*64
                        + ($ord4-128);
    }

    if ( !isset($chr{5}) ) {
        \trigger_error('Short sequence - at least 6 bytes expected, only 5 seen');
        return FALSE;
    }
    if ($ord0>=252 && $ord0<=253) {
        return ($ord0-252) * 1073741824
            + ($ord1-128)*16777216
                + ($ord2-128)*262144
                    + ($ord3-128)*4096
                        + ($ord4-128)*64
                            + (\ord($chr{5})-128);
    }

    if ( $ord0 >= 254 && $ord0 <= 255 ) {
        \trigger_error('Invalid UTF-8 with surrogate ordinal '.$ord0);
        return FALSE;
    }

}

function str_split($str, $split_len = 1)
{
	if ( !\preg_match('/^[0-9]+$/',$split_len) || $split_len < 1 ) {
		return FALSE;
	}

	$len = \phputf8\strlen($str);
	if ( $len <= $split_len ) {
		return array($str);
	}

	\preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
	return $ar[0];
}

function strrev($str)
{
	\preg_match_all('/./us', $str, $ar);
	return \join('', \array_reverse($ar[0]));
}

function strpos($str, $needle, $offset = NULL)
{
	if (\is_null($offset)) {
		$ar = \explode($needle, $str, 2);
		if (\count($ar) > 1) {
			return \phputf8\strlen($ar[0]);
		}
		return FALSE;
    } else {
		if (!\is_int($offset)) {
			\trigger_error('utf8_strpos: Offset must be an integer', E_USER_ERROR);
			return FALSE;
		}

		$str = \phputf8\substr($str, $offset);

		if (FALSE !== ($pos = \phputf8\strpos($str, $needle))) {
			return $pos + $offset;
		}

		return FALSE;
	}
}

function strrpos($str, $needle, $offset = NULL)
{
    if (\is_null($offset)) {

        $ar = \explode($needle, $str);

        if (\count($ar) > 1) {
            // Pop off the end of the string where the last match was made
            \array_pop($ar);
            $str = \join($needle,$ar);
            return \phputf8\strlen($str);
        }
        return FALSE;
    } else {
        if (!\is_int($offset)) {
            \trigger_error('utf8_strrpos expects parameter 3 to be long', E_USER_WARNING);
            return FALSE;
        }

        $str = \phputf8\substr($str, $offset);

        if (FALSE !== ($pos = \phputf8\strrpos($str, $needle))) {
            return $pos + $offset;
        }

        return FALSE;
    }
}

function strip_non_ascii($str)
{
    \ob_start();
    while ( \preg_match(
        '/^([\x00-\x7F]+)|([^\x00-\x7F]+)/S',
            $str, $matches) ) {
        if ( !isset($matches[2]) ) {
            echo $matches[0];
        }
        $str = \substr($str, \strlen($matches[0]));
    }
    $result = \ob_get_contents();
    \ob_end_clean();
    return $result;
}
