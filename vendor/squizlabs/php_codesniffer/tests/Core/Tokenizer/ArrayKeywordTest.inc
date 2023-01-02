<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ArrayKeywordTest.inc
 *  Last Modified: 3.01.23 г., 0:06 ч.
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

/* testEmptyArray */
$var = [];

/* testArrayWithSpace */
$var = [1 => 10];

/* testArrayWithComment */
$var = array /*comment*/
(
             1 => 10,
);

/* testNestingArray */
$var = [
    /* testNestedArray */
    [
        'key'     => 'value',

        /* testClosureReturnType */
        'closure' => function ($a) use ($global): array {},
    ],
];

/* testFunctionDeclarationParamType */
function foo(array $a) {}

/* testFunctionDeclarationReturnType */
function foo($a): int|array|null {}

class Bar
{

    /* testClassConst */
    public const ARRAY = [];

    /* testClassMethod */
    public function array() {}

}
