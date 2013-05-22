<?php

namespace patchwork;

if (PCRE_VERSION < '8.32')
{
	// (CRLF|([ZWNJ-ZWJ]|T+|L*(LV?V+|LV|LVT)T*|L+|[^Control])[Extend]*|[Control])
	// This regular expression is not up to date with the latest unicode grapheme cluster definition.
	// However, until http://bugs.exim.org/show_bug.cgi?id=1279 is fixed, it's still better than \X

	define('GRAPHEME_CLUSTER_RX', '(?:\r\n|(?:[ -~\x{200C}\x{200D}]|[ᆨ-ᇹ]+|[ᄀ-ᅟ]*(?:[가개갸걔거게겨계고과괘괴교구궈궤귀규그긔기까깨꺄꺠꺼께껴꼐꼬꽈꽤꾀꾜꾸꿔꿰뀌뀨끄끠끼나내냐냬너네녀녜노놔놰뇌뇨누눠눼뉘뉴느늬니다대댜댸더데뎌뎨도돠돼되됴두둬뒈뒤듀드듸디따때땨떄떠떼뗘뗴또똬뙈뙤뚀뚜뚸뛔뛰뜌뜨띄띠라래랴럐러레려례로롸뢔뢰료루뤄뤠뤼류르릐리마매먀먜머메며몌모뫄뫠뫼묘무뭐뭬뮈뮤므믜미바배뱌뱨버베벼볘보봐봬뵈뵤부붜붸뷔뷰브븨비빠빼뺘뺴뻐뻬뼈뼤뽀뽜뽸뾔뾰뿌뿨쀄쀠쀼쁘쁴삐사새샤섀서세셔셰소솨쇄쇠쇼수숴쉐쉬슈스싀시싸쌔쌰썌써쎄쎠쎼쏘쏴쐐쐬쑈쑤쒀쒜쒸쓔쓰씌씨아애야얘어에여예오와왜외요우워웨위유으의이자재쟈쟤저제져졔조좌좨죄죠주줘줴쥐쥬즈즤지짜째쨔쨰쩌쩨쪄쪠쪼쫘쫴쬐쬬쭈쭤쮀쮜쮸쯔쯰찌차채챠챼처체쳐쳬초촤쵀최쵸추춰췌취츄츠츼치카캐캬컈커케켜켸코콰쾌쾨쿄쿠쿼퀘퀴큐크킈키타태탸턔터테텨톄토톼퇘퇴툐투퉈퉤튀튜트틔티파패퍄퍠퍼페펴폐포퐈퐤푀표푸풔풰퓌퓨프픠피하해햐햬허헤혀혜호화홰회효후훠훼휘휴흐희히]?[ᅠ-ᆢ]+|[가-힣])[ᆨ-ᇹ]*|[ᄀ-ᅟ]+|[^\p{Cc}\p{Cf}\p{Zl}\p{Zp}])[\p{Mn}\p{Me}\x{09BE}\x{09D7}\x{0B3E}\x{0B57}\x{0BBE}\x{0BD7}\x{0CC2}\x{0CD5}\x{0CD6}\x{0D3E}\x{0D57}\x{0DCF}\x{0DDF}\x{200C}\x{200D}\x{1D165}\x{1D16E}-\x{1D172}]*|[\p{Cc}\p{Cf}\p{Zl}\p{Zp}])');
}
else
{
	define('GRAPHEME_CLUSTER_RX', '\X');
}

function strlen($s)
{
    $ulen_mask = array("\xC0" => 2, "\xD0" => 2, "\xE0" => 3, "\xF0" => 4);

	$i = 0; $j = 0;
	$len = \strlen($s);

	while ($i < $len)
	{
		$u = $s[$i] & "\xF0";
		$i += isset($ulen_mask[$u]) ? $ulen_mask[$u] : 1;
		++$j;
	}

	return $j;
}

function substr($s, $start, $length = 2147483647)
{
	$slen = \patchwork\strlen($s);
	$start = (int) $start;

	if (0 > $start) $start += $slen;
	if (0 > $start) return false;
	if ($start >= $slen) return false;

	$rx = $slen - $start;

	if (0 > $length) $length += $rx;
	if (0 === $length) return '';
	if (0 > $length) return false;

	if ($length > $rx) $length = $rx;

	$rx = '/^' . ($start ? \patchwork\preg_offset($start) : '') . '(' . \patchwork\preg_offset($length) . ')/u';

	$s = \preg_match($rx, $s, $s) ? $s[1] : '';

	return $s;
}

function preg_offset($offset)
{
	$rx = array();
	$offset = (int) $offset;

	while ($offset > 65535)
	{
		$rx[] = '.{65535}';
		$offset -= 65535;
	}

	return \implode('', $rx) . '.{' . $offset . '}';
}

function utf8_is_valid($s)
{
	return (bool) \preg_match('//u', $s);
}

function utf8_ord($s)
{
	$a = ($s = \unpack('C*', \substr($s, 0, 4))) ? $s[1] : 0;
	if (0xF0 <= $a) return (($a - 0xF0)<<18) + (($s[2] - 0x80)<<12) + (($s[3] - 0x80)<<6) + $s[4] - 0x80;
	if (0xE0 <= $a) return (($a - 0xE0)<<12) + (($s[2] - 0x80)<<6) + $s[3] - 0x80;
	if (0xC0 <= $a) return (($a - 0xC0)<<6) + $s[2] - 0x80;
	return $a;
}

function str_split($s, $len = 1)
{
	if (1 > $len = (int) $len)
	{
		$len = \func_get_arg(1);
		return \str_split($s, $len);
	}

	\preg_match_all('/' . GRAPHEME_CLUSTER_RX . '/u', $s, $a);
	$a = $a[0];

	if (1 == $len) return $a;

	$s = array();
	$p = -1;

	foreach ($a as $l => $a)
	{
		if ($l % $len) $s[$p] .= $a;
		else $s[++$p] = $a;
	}

	return $s;
}

function chr($c)
{
	if (0x80 > $c %= 0x200000) return \chr($c);
	if (0x800 > $c) return \chr(0xC0 | $c>>6) . \chr(0x80 | $c & 0x3F);
	if (0x10000 > $c) return \chr(0xE0 | $c>>12) . \chr(0x80 | $c>>6 & 0x3F) . \chr(0x80 | $c & 0x3F);
	return \chr(0xF0 | $c>>18) . \chr(0x80 | $c>>12 & 0x3F) . \chr(0x80 | $c>>6 & 0x3F) . \chr(0x80 | $c & 0x3F);
}

function strrev($s)
{
	$s = \patchwork\str_split($s);
	return \implode('', \array_reverse($s));
}

function strpos($haystack, $needle, $offset = 0)
{
	if ($offset = (int) $offset) $haystack = \patchwork\substr($haystack, $offset, 2147483647);
	$pos = \strpos($haystack, $needle);
	return false === $pos ? false : ($offset + ($pos ? \patchwork\strlen(\substr($haystack, 0, $pos)) : 0));
}

function strrpos($haystack, $needle, $offset = 0)
{
	if ($offset != (int) $offset)
	{
		$offset = 0;
	}
	else if ($offset = (int) $offset)
	{
		$haystack = \patchwork\substr($haystack, $offset, 2147483647);
	}

	$needle = \patchwork\substr($needle, 0, 1);
	$pos = \strpos(\strrev($haystack), \strrev($needle));
	return false === $pos ? false : \patchwork\strlen($pos ? \substr($haystack, 0, -$pos) : $haystack);
}

function utf8_encode($s)
{
	$len = \strlen($s);
	$e = $s . $s;

	for ($i = 0, $j = 0; $i < $len; ++$i, ++$j) switch (true)
	{
		case $s[$i] < "\x80": $e[$j] = $s[$i]; break;
		case $s[$i] < "\xC0": $e[$j] = "\xC2"; $e[++$j] = $s[$i]; break;
		default:              $e[$j] = "\xC3"; $e[++$j] = \chr(\ord($s[$i]) - 64); break;
	}

	return \substr($e, 0, $j);
}

function utf8_decode($s)
{
	$len = \strlen($s);

	for ($i = 0, $j = 0; $i < $len; ++$i, ++$j)
	{
		switch ($s[$i] & "\xF0")
		{
			case "\xC0":
			case "\xD0":
				$c = (\ord($s[$i] & "\x1F") << 6) | \ord($s[++$i] & "\x3F");
				$s[$j] = $c < 256 ? \chr($c) : '?';
				break;

			case "\xF0": ++$i;
			case "\xE0":
				$s[$j] = '?';
				$i += 2;
				break;

			default:
				$s[$j] = $s[$i];
		}
	}

	return \substr($s, 0, $j);
}
