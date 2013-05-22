<?php

function my_var_dump($var)
{
	ob_start();
	var_dump($var);
	$result = ob_get_clean();

	return $result;
}

function compare()
{
$utf8 = 'Iñtërnâtiônàlizætiøn';
$ascii = 'Internationalisation';

$html = '
<table>
<thead>
<tr>
<th>Function call</th>
<th>PHP Native</th>
<th>PHP Multibyte</th>
<th>PHP iconv</th>
<th>phputf8</th>
<th>Patchwork</th>
<th>PECL UTF-8</th>
</tr>
<thead>
<tbody>';

$value = $ascii;
$php       = strlen($value);
$mb        = mb_strlen($value, 'UTF-8');
$iconv     = iconv_strlen($value, 'UTF-8');
$phputf8   = phputf8\strlen($value);
$patchwork = patchwork\strlen($value);
$pecl      = utf8_strlen($value);
$html .= '
<tr>
<td>strlen(' . $value . ')</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $utf8;
$php       = strlen($value);
$mb        = mb_strlen($value, 'UTF-8');
$iconv     = iconv_strlen($value, 'UTF-8');
$phputf8   = phputf8\strlen($value);
$patchwork = patchwork\strlen($value);
$pecl      = utf8_strlen($value);
$html .= '
<tr>
<td>strlen(' . $value . ')</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $ascii;
$php       = substr($value, 3);
$mb        = mb_substr($value, 3, 2000, 'UTF-8');
$iconv     = iconv_substr($value, 3, 2000, 'UTF-8');
$phputf8   = phputf8\substr($value, 3);
$patchwork = patchwork\substr($value, 3);
$pecl      = utf8_substr($value, 3);
$html .= '
<tr>
<td>substr(' . $value . ', 3)</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $utf8;
$php       = substr($value, 3);
$mb        = mb_substr($value, 3, 2000, 'UTF-8');
$iconv     = iconv_substr($value, 3, 2000, 'UTF-8');
$phputf8   = phputf8\substr($value, 3);
$patchwork = patchwork\substr($value, 3);
$pecl      = utf8_substr($value, 3);
$html .= '
<tr>
<td>substr(' . $value . ', 3)</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $ascii;
$php       = substr($value, 3, 7);
$mb        = mb_substr($value, 3, 7, 'UTF-8');
$iconv     = iconv_substr($value, 3, 7, 'UTF-8');
$phputf8   = phputf8\substr($value, 3, 7);
$patchwork = patchwork\substr($value, 3, 7);
$pecl      = utf8_substr($value, 3, 7);
$html .= '
<tr>
<td>substr(' . $value . ', 3, 7)</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $utf8;
$php       = substr($value, 3, 7);
$mb        = mb_substr($value, 3, 7, 'UTF-8');
$iconv     = iconv_substr($value, 3, 7, 'UTF-8');
$phputf8   = phputf8\substr($value, 3, 7);
$patchwork = patchwork\substr($value, 3, 7);
$pecl      = utf8_substr($value, 3, 7);
$html .= '
<tr>
<td>substr(' . $value . ', 3, 7)</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $ascii;
$php       = strrev($value);
$phputf8   = phputf8\strrev($value);
$patchwork = patchwork\strrev($value);
$pecl      = utf8_strrev($value);

$html .= '
<tr>
<td>strrev(' . $value . ')</td>
<td>' . my_var_dump($php) . '</td>
<td>--</td>
<td>--</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $utf8;
$php       = strrev($value);
$phputf8   = phputf8\strrev($value);
$patchwork = patchwork\strrev($value);
$pecl      = utf8_strrev($value);
$html .= '
<tr>
<td>strrev(' . $value . ')</td>
<td>' . my_var_dump($php) . '</td>
<td>--</td>
<td>--</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = 'n';
$php       = ord($value);
$phputf8   = phputf8\utf8_ord($value);
$patchwork = patchwork\utf8_ord($value);
$pecl      = utf8_ord($value);
$html .= '
<tr>
<td>ord(' . $value . ')</td>
<td>' . my_var_dump($php) . '</td>
<td>--</td>
<td>--</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = 'ñ';
$php       = ord($value);
$phputf8   = phputf8\utf8_ord($value);
$patchwork = patchwork\utf8_ord($value);
$pecl      = utf8_ord($value);
$html .= '
<tr>
<td>ord(' . $value . ')</td>
<td>' . my_var_dump($php) . '</td>
<td>--</td>
<td>--</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = 110;
$php       = chr($value);
$patchwork = patchwork\chr($value);
$pecl      = utf8_chr($value);
$html .= '
<tr>
<td>chr(' . $value . ')</td>
<td>' . my_var_dump($php) . '</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = 241;
$php       = chr($value);
$patchwork = patchwork\chr($value);
$pecl      = utf8_chr($value);
$html .= '
<tr>
<td>chr(' . $value . ')</td>
<td>' . my_var_dump($php) . '</td>
<td>--</td>
<td>--</td>
<td>--</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $ascii;
$php       = strpos($value, 'n');
$mb        = mb_strpos($value, 'n', 0, 'UTF-8');
$iconv     = iconv_strpos($value, 'n', 0, 'UTF-8');
$phputf8   = phputf8\strpos($value, 'n');
$patchwork = patchwork\strpos($value, 'n');
$pecl      = utf8_strpos($value, 'n');
$html .= '
<tr>
<td>strpos(' . $value . ', \'n\')</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $utf8;
$php       = strpos($value, 'ñ');
$mb        = mb_strpos($value, 'ñ', 0, 'UTF-8');
$iconv     = iconv_strpos($value, 'ñ', 0, 'UTF-8');
$phputf8   = phputf8\strpos($value, 'ñ');
$patchwork = patchwork\strpos($value, 'ñ');
$pecl      = utf8_strpos($value, 'ñ');
$html .= '
<tr>
<td>strpos(' . $value . ', \'ñ\')</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $ascii;
$php       = strpos($value, 'n', 11);
$mb        = mb_strpos($value, 'n', 11, 'UTF-8');
$iconv     = iconv_strpos($value, 'n', 11, 'UTF-8');
$phputf8   = phputf8\strpos($value, 'n', 11);
$patchwork = patchwork\strpos($value, 'n', 11);
$pecl      = utf8_strpos($value, 'n', 11);
$html .= '
<tr>
<td>strpos(' . $value . ', \'n\')</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $utf8;
$php       = strpos($value, 'n', 11);
$mb        = mb_strpos($value, 'n', 11, 'UTF-8');
$iconv     = iconv_strpos($value, 'n', 11, 'UTF-8');
$phputf8   = phputf8\strpos($value, 'n', 11);
$patchwork = patchwork\strpos($value, 'n', 11);
$pecl      = utf8_strpos($value, 'n', 11);
$html .= '
<tr>
<td>strpos(' . $value . ', \'n\', 11)</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $ascii;
$php       = strrpos($value, 'n');
$mb        = mb_strrpos($value, 'n', 0, 'UTF-8');
$iconv     = iconv_strrpos($value, 'n', 'UTF-8');
$phputf8   = phputf8\strrpos($value, 'n');
$patchwork = patchwork\strrpos($value, 'n');
$pecl      = utf8_strrpos($value, 'n');
$html .= '
<tr>
<td>strrpos(' . $value . ', \'n\')</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $utf8;
$php       = strrpos($value, 'n');
$mb        = mb_strrpos($value, 'n', 0, 'UTF-8');
$iconv     = iconv_strrpos($value, 'n', 'UTF-8');
$phputf8   = phputf8\strrpos($value, 'n');
$patchwork = patchwork\strrpos($value, 'n');
$pecl      = utf8_strrpos($value, 'n');
$html .= '
<tr>
<td>strrpos(' . $value . ', \'n\')</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>' . my_var_dump($iconv) . '</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $ascii;
$php       = strrpos($value, 'n', 11);
$mb        = mb_strrpos($value, 'n', 11, 'UTF-8');
$phputf8   = phputf8\strrpos($value, 'n', 11);
$patchwork = patchwork\strrpos($value, 'n', 11);
$pecl      = utf8_strrpos($value, 'n', 11);
$html .= '
<tr>
<td>strrpos(' . $value . ', \'n\', 11)</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>--</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$value = $utf8;
$php       = strrpos($value, 'n', 11);
$mb        = mb_strrpos($value, 'n', 11, 'UTF-8');
$phputf8   = phputf8\strrpos($value, 'n', 11);
$patchwork = patchwork\strrpos($value, 'n', 11);
$pecl      = utf8_strrpos($value, 'n', 11);
$html .= '
<tr>
<td>strrpos(' . $value . ', \'n\', 11)</td>
<td>' . my_var_dump($php) . '</td>
<td>' . my_var_dump($mb) . '</td>
<td>--</td>
<td>' . my_var_dump($phputf8) . '</td>
<td>' . my_var_dump($patchwork) . '</td>
<td>' . my_var_dump($pecl) . '</td>
</tr>';

$html .= '</tbody></table>';
return $html;
}
