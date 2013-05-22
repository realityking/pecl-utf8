<?php


function benchmark($ascii, $utf8, $i, $extra = false)
{
$html = '
<table>
<thead>
<tr>
<th>Function</th>
<th>PHP Native</th>
<th>PHP Multibyte</th>
<th>PHP iconv</th>
<th>phputf8</th>
<th>Patchwork</th>
<th>PECL UTF-8</th>
</tr>
<thead>
<tbody>';

$php       = strlen_php($ascii, $i);
$mb        = strlen_mb($ascii, $i);
$iconv     = strlen_iconv($ascii, $i);
$phputf8   = strlen_phputf8($ascii, $i);
$patchwork = strlen_patchwork($ascii, $i);
$pecl      = strlen_pecl($ascii, $i);
$html .= '
<tr>
<td>strlen - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')**</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = strlen_php($utf8, $i);
$mb        = strlen_mb($utf8, $i);
$iconv     = strlen_iconv($utf8, $i);
$phputf8   = strlen_phputf8($utf8, $i);
$patchwork = strlen_patchwork($utf8, $i);
$pecl      = strlen_pecl($utf8, $i);
$html .= '
<tr>
<td>strlen - UTF-8</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')*</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')**</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = substr_php($ascii, $i);
$mb        = substr_mb($ascii, $i);
$iconv     = substr_iconv($ascii, $i);
$phputf8   = substr_phputf8($ascii, $i);
$patchwork = substr_patchwork($ascii, $i);
$pecl      = substr_pecl($ascii, $i);
$html .= '
<tr>
<td>substr - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = substr_php($utf8, $i);
$mb        = substr_mb($utf8, $i);
$iconv     = substr_iconv($utf8, $i);
$phputf8   = substr_phputf8($utf8, $i);
$patchwork = substr_patchwork($utf8, $i);
$pecl      = substr_pecl($utf8, $i);
$html .= '
<tr>
<td>substr - UTF-8</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')*</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = str_split_php($ascii, $i);
$phputf8   = str_split_phputf8($ascii, $i);
$patchwork = str_split_patchwork($ascii, $i);
$pecl      = str_split_pecl($ascii, $i);
$html .= '
<tr>
<td>str_split - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = str_split_php($utf8, $i);
$phputf8   = str_split_phputf8($utf8, $i);
$patchwork = str_split_patchwork($utf8, $i);
$pecl      = str_split_pecl($utf8, $i);
$html .= '
<tr>
<td>str_split - UTF-8</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')*</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = strrev_php($ascii, $i);
$phputf8   = strrev_phputf8($ascii, $i);
$patchwork = strrev_patchwork($ascii, $i);
$pecl      = strrev_pecl($ascii, $i);
$html .= '
<tr>
<td>strrev - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = strrev_php($utf8, $i);
$phputf8   = strrev_phputf8($utf8, $i);
$patchwork = strrev_patchwork($utf8, $i);
$pecl      = strrev_pecl($utf8, $i);
$html .= '
<tr>
<td>strrev - UTF-8</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')*</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = strpos_php($ascii, $i);
$mb        = strpos_mb($ascii, $i);
$iconv     = strpos_iconv($ascii, $i);
$phputf8   = strpos_phputf8($ascii, $i);
$patchwork = strpos_patchwork($ascii, $i);
$pecl      = strpos_pecl($ascii, $i);
$html .= '
<tr>
<td>strpos - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = strpos_php($utf8, $i);
$mb        = strpos_mb($utf8, $i);
$iconv     = strpos_iconv($utf8, $i);
$phputf8   = strpos_phputf8($utf8, $i);
$patchwork = strpos_patchwork($utf8, $i);
$pecl      = strpos_pecl($utf8, $i);
$html .= '
<tr>
<td>strpos - UTF-8</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')*</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = strrpos_php($ascii, $i);
$mb        = strrpos_mb($ascii, $i);
$iconv     = strrpos_iconv($ascii, $i);
$phputf8   = strrpos_phputf8($ascii, $i);
$patchwork = strrpos_patchwork($ascii, $i);
$pecl      = strrpos_pecl($ascii, $i);
$html .= '
<tr>
<td>strrpos - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = strrpos_php($utf8, $i);
$mb        = strrpos_mb($utf8, $i);
$iconv     = strrpos_iconv($utf8, $i);
$phputf8   = strrpos_phputf8($utf8, $i);
$patchwork = strrpos_patchwork($utf8, $i);
$pecl      = strrpos_pecl($utf8, $i);
$html .= '
<tr>
<td>strrpos - UTF-8</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')*</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

if ($extra) {

$php       = ord_php('U', $i);
$phputf8   = ord_phputf8('U', $i);
$patchwork = ord_patchwork('U', $i);
$pecl      = ord_pecl('U', $i);
$html .= '
<tr>
<td>ord - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = ord_php('Ü', $i);
$phputf8   = ord_phputf8('Ü', $i);
$patchwork = ord_patchwork('Ü', $i);
$pecl      = ord_pecl('Ü', $i);
$html .= '
<tr>
<td>ord - UTF-8</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')*</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = chr_php(97, $i);
$patchwork = chr_patchwork(97, $i);
$pecl      = chr_pecl(97, $i);
$html .= '
<tr>
<td>chr - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = chr_php(241, $i);
$patchwork = chr_patchwork(241, $i);
$pecl      = chr_pecl(241, $i);
$html .= '
<tr>
<td>chr - UTF-8</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')*</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

}

$phputf8   = string_is_ascii_phputf8($ascii, $i);
$pecl      = string_is_ascii_pecl($ascii, $i);
$html .= '
<tr>
<td>string_is_ascii - ASCII</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>--</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$phputf8   = string_is_ascii_phputf8($utf8, $i);
$pecl      = string_is_ascii_pecl($utf8, $i);
$html .= '
<tr>
<td>string_is_ascii - UTF-8</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>--</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$phputf8   = strip_non_ascii_phputf8($ascii, $i);
$pecl      = strip_non_ascii_pecl($ascii, $i);
$html .= '
<tr>
<td>strip_non_ascii - ASCII</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>--</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$phputf8   = strip_non_ascii_phputf8($utf8, $i);
$pecl      = strip_non_ascii_pecl($utf8, $i);
$html .= '
<tr>
<td>strip_non_ascii - UTF-8</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')</td>
<td>--</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$phputf8   = utf8_is_valid_phputf8($ascii, $i);
$patchwork = utf8_is_valid_patchwork($ascii, $i);
$pecl      = utf8_is_valid_pecl($ascii, $i);
$html .= '
<tr>
<td>utf8_is_valid - ASCII</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')***</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$phputf8   = utf8_is_valid_phputf8($utf8, $i);
$patchwork = utf8_is_valid_patchwork($utf8, $i);
$pecl      = utf8_is_valid_pecl($utf8, $i);
$html .= '
<tr>
<td>utf8_is_valid - UTF-8</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . f($phputf8/$pecl) . ' (' . f($phputf8) . ')***</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = utf8_encode_php($ascii, $i);
$mb        = utf8_encode_mb($ascii, $i);
$icon      = utf8_encode_iconv($ascii, $i);
$patchwork = utf8_encode_patchwork($ascii, $i);
$pecl      = utf8_encode_pecl($ascii, $i);
$html .= '
<tr>
<td>utf8_encode - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>--</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = utf8_decode_php($ascii, $i);
$mb        = utf8_decode_mb($ascii, $i);
$icon      = utf8_decode_iconv($ascii, $i);
$patchwork = utf8_decode_patchwork($ascii, $i);
$pecl      = utf8_decode_pecl($ascii, $i);
$html .= '
<tr>
<td>utf8_decode - ASCII</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>--</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$php       = utf8_decode_php($utf8, $i);
$mb        = utf8_decode_mb($utf8, $i);
$icon      = utf8_decode_iconv($utf8, $i);
$patchwork = utf8_decode_patchwork($utf8, $i);
$pecl      = utf8_decode_pecl($utf8, $i);
$html .= '
<tr>
<td>utf8_decode - UTF-8</td>
<td>' . f($php/$pecl) . ' (' . f($php) . ')</td>
<td>' . f($mb/$pecl) . ' (' . f($mb) . ')</td>
<td>' . f($iconv/$pecl) . ' (' . f($iconv) . ')</td>
<td>--</td>
<td>' . f($patchwork/$pecl) . ' (' . f($patchwork) . ')</td>
<td>' . f($pecl/$pecl) . ' (' . f($pecl) . ')</td>
</tr>';

$html .= '</tbody></table>';
return $html;
}
