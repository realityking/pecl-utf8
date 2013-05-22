<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/phputf8.php';
require __DIR__ . '/patchwork.php';
require __DIR__ . '/functions.php';
require __DIR__ . '/bench.php';
require __DIR__ . '/comparison.php';

dl('utf8.so');

$utf8_s = 'Iñtërnâtiônàlizætiøn';
$ascii_s = 'Internationalisation';

$utf8_m  = 'Geocaching, auch GPS-Schnitzeljagd genannt, ist eine Art elektronische Schatzsuche oder Schnitzeljagd. Die Verstecke („Geocaches“, kurz „Caches“) werden anhand geografischer Koordinaten im World Wide Web veröffentlicht und können anschließend mit Hilfe eines GPS-Empfängers gesucht werden. Mit genauen Landkarten ist auch die Suche ohne GPS-Empfänger möglich. Ein Geocache ist in der Regel ein wasserdichter Behälter, in dem sich ein Logbuch sowie verschiedene kleine Tauschgegenstände befinden. Jeder Besucher trägt sich in das Logbuch ein, um seine erfolgreiche Suche zu dokumentieren. Anschließend wird der Geocache wieder an der Stelle versteckt, an der er zuvor gefunden wurde. Der Fund wird im Internet auf der zugehörigen Seite vermerkt und gegebenenfalls durch Fotos ergänzt. So können auch andere Personen – insbesondere der Verstecker oder „Owner“ – die Geschehnisse rund um den Geocache verfolgen. Weltweit existieren über 2 Millionen Geocaches.';
$ascii_m = 'Geocaching, auch GPS-Schnitzeljagd genannt, ist eine Art elektronische Schatzsuche oder Schnitzeljagd. Die Verstecke ("Geocaches", kurz "Caches") werden anhand geografischer Koordinaten im World Wide Web veroeffentlicht und koennen anschliessend mit Hilfe eines GPS-Empfaengers gesucht werden. Mit genauen Landkarten ist auch die Suche ohne GPS-Empfaenger moeglich. Ein Geocache ist in der Regel ein wasserdichter Behaelter, in dem sich ein Logbuch sowie verschiedene kleine Tauschgegenstaende befinden. Jeder Besucher traegt sich in das Logbuch ein, um seine erfolgreiche Suche zu dokumentieren. Anschliessend wird der Geocache wieder an der Stelle versteckt, an der er zuvor gefunden wurde. Der Fund wird im Internet auf der zugehoerigen Seite vermerkt und gegebenenfalls durch Fotos ergaenzt. So koennen auch andere Personen - insbesondere der Verstecker oder "Owner" - die Geschehnisse rund um den Geocache verfolgen. Weltweit existieren ueber 2 Millionen Geocaches.';
$utf8_l = file_get_contents(__DIR__ . '/utf8.txt');
$ascii_l = file_get_contents(__DIR__ . '/ascii.txt');

function f($i) {
	return number_format($i, 4);
}

$html = '
<!DOCTPYE html>
<html>
<head>
<meta charset="utf-8" />
<title>Comparison of PHP UTF-8 functions</title>
</head>
<body>
<h1>Comparison of PHP UTF-8 functions</h1>
<p>For phputf8 and patchwork the PHP implementation with the least dependency on extensions was choosen.</p>
<h2>Performance comparison</h2>
<h3>Short string (ASCII: ' . strlen($ascii_s) . ' Bytes, UTF-8: ' . strlen($utf8_s) . ' Bytes)</h3>
<p>Each test consistent of 100000 calls.</p>';

$html .= benchmark($ascii_s, $utf8_s, 100000, true);

echo "Benchmark short done\n";

$html .=  '<h3>Medium string (ASCII: ' . number_format(strlen($ascii_m)/1024, 2) . ' Kilobytes, UTF-8: ' . number_format(strlen($utf8_m)/1024, 2) . ' Kilobytes)</h3><p>Each test consistent of 10000 calls.</p>';

$html .= benchmark($ascii_m, $utf8_m, 10000);

echo "Benchmark medium done\n";

$html .=  '<h3>Long string (ASCII: ' . number_format(strlen($ascii_l)/1024, 2) . ' Kilobytes, UTF-8: ' . number_format(strlen($utf8_l)/1024, 2) . ' Kilobytes)</h3><p>Each test consistent of 100 calls.</p>';

$html .= benchmark($ascii_l, $utf8_l, 100);

echo "Benchmark long done\n";

$html .= '
<p>
*The PHP implementation returns bad results. It\'s listed here to establish a baseline.<br />
** The same alogirthm as in phputf8 is also available.<br />
*** This algortim works on an outdated assumption, patchwork is more represantive for what\'s possible in userland.
</p>';

$html .= '<h1>Output comparison</h1>';

$html .= compare();

echo "Compare done\n";

$html .= '</body></html>';

file_put_contents(__DIR__ . '/results.html', $html);

unset($html);

echo "Peak memory useage: " . number_format(memory_get_peak_usage()/1024/1024, 2) . "MB\n";
echo "Current memory useage: " . number_format(memory_get_usage()/1024/1024, 2) . "MB\n";
