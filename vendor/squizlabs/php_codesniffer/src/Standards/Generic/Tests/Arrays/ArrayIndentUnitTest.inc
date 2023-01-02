<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ArrayIndentUnitTest.inc
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

$var = [1,2,3];
$var = [
    1,
    2,
    3
];
$var = [
    1,
    2,
    /* three */ 3,
];
$var = [
1,
        2,
    /* three */ 3,
 ];

$var = [
    1 => 'one',
    2 => 'two',
    3 => 'three'
];
$var = [
    1 => 'one',
    2 => 'two',
    /* three */ 3 => 'three',
];
$var = [
1 => 'one',
        2 => 'two',
    /* three */ 3 => 'three',
    ];

$var = array(
    'one' => function() {
        $foo = [1,2,3];
        $bar = [
            1,
            2,
            3];
    },
    'two' => 2,
);

return [
    [
        'foo' => true,
    ]
];

$array = [
    'foo' => 'foo',
    'bar' => $baz ?
        ['abc'] :
        ['def'],
    'hey' => $baz ??
        ['one'] ??
        ['two'],
    'fn' =>
        fn ($x) => yield 'k' => $x,
  $a ?? $b,
  $c ? $d : $e,
];

$foo =
[
    'bar' =>
   [
    ],
];

$foo = [
    'foo'
        . 'bar',
    [
            'baz',
            'qux',
        ],
];

// phpcs:set Generic.Arrays.ArrayIndent indent 2

$var = [
1 => 'one',
        2 => 'two',
    /* three */ 3 => 'three',
    ];

// phpcs:set Generic.Arrays.ArrayIndent indent 4

$array = array(
    match ($test) { 1 => 'a', 2 => 'b' }
          => 'dynamic keys, woho!',
);

$array = [
  match ($test) { 1 => 'a', 2 => 'b' }
       => 'dynamic keys, woho!',
];
