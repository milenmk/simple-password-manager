<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ArrayBracketSpacingUnitTest.inc
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

$myArray['key']                = $value;
$myArray[/* key start */'key'] = $value;
$myArray[/* key start */'key'/* key end */] = $value;
$myArray  [  'key'  ]            = $value;
if ($array[($index + 1)] === true) {
} else if ($array  [ ($index + 1) ] === null) {
}
$array = [
    'foo' => 'bar',
    'bar' => 'foo',
];

if ($foo) {}
[$a, $b] = $c;

echo foo()[ 1 ];

echo $this->addedCustomFunctions['nonce'];
echo $this->deprecated_functions[ $function_name ]['version'];

echo [ 1,2,3 ][0];
echo [ 1,2,3 ][ 0 ];
echo 'PHP'[ 0 ];

$array = [];
$var = $var[$var[$var]]] // Syntax error
$var = $var[$var[$var]; // Syntax error

$myArray[ /* key start */'key'] = $value;
$myArray[ /* key start */'key'/* key end */ ] = $value;
