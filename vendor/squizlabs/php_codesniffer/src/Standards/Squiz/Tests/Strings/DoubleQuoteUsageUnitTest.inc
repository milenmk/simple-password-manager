<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DoubleQuoteUsageUnitTest.inc
 *  Last Modified: 18.06.22 г., 10:21 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.2.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

$string = "Hello\tThere";
$string = "Hello There\r\n";
$string = 'Hello There';
$string = "Hello $there";
$string = 'Hello'."$there '".'hi';
$string = "My name is 'Greg'";
$string = 'Hello' . ' There' . "\n";
$string = "Hello There\f";
$string = 'Hello There\b';
$string = "Hello\vThere";
$string = "\x0";
$string = 'Hello '.$there.' Greg';
$string = "<div class='$class'>";
$string = "Value: $var[test]";
$string = "\0";
$string = "\$var";

$x = "bar = '$z',
baz = '" . $a . "'...$x";

$string = 'Hello
there';
$string = 'Hello
there';

$string = "\123 \234" . '\u123' . "\e";

echo "window.location = \"".$url."\";\n";
echo ''

$string = 'Hello
			there';

function test() {
    echo "It Worked';
}
