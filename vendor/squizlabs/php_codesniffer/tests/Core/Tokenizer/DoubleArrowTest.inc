<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DoubleArrowTest.inc
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

function simpleLongArray($x)
{

    return [
        /* testLongArrayArrowSimple */
        0 => 'Zero',
    ];
}

function simpleShortArray($x)
{

    return [
        /* testShortArrayArrowSimple */
        0 => 'Zero',
    ];
}

function simpleLongList($x)
{

    [
        /* testLongListArrowSimple */
        0 => $a,
    ] = $x;
}

function simpleShortList($x)
{

    [
        /* testShortListArrowSimple */
        0 => $a,
    ] = $x;
}

function simpleYield($x)
{

    $i = 0;
    foreach (explode("\n", $x) as $line) {
        /* testYieldArrowSimple */
        yield ++$i => $line;
    }
}

function simpleForeach($x)
{

    /* testForeachArrowSimple */
    foreach ($x as $k => $value) {
    }
}

function simpleMatch($x)
{

    return match ($x) {
        /* testMatchArrowSimpleSingleCase */
        0       => 'Zero',
        /* testMatchArrowSimpleMultiCase */
        2, 4, 6 => 'Zero',
        /* testMatchArrowSimpleSingleCaseWithTrailingComma */
        1,      => 'Zero',
        /* testMatchArrowSimpleMultiCaseWithTrailingComma */
        3, 5,   => 'Zero',
    };
}

function simpleArrowFunction($y)
{

    /* testFnArrowSimple */
    return fn($y) => callMe($y);
}

function matchNestedInMatch()
{

    $x = match ($y) {
        /* testMatchArrowNestedMatchOuter */
        default, => match ($z) {
            /* testMatchArrowNestedMatchInner */
            1 => 1
        },
    };
}

function matchNestedInLongArrayValue()
{

    $array = [
        /* testLongArrayArrowWithNestedMatchValue1 */
        'a' => match ($test) {
            /* testMatchArrowInLongArrayValue1 */
            1 => 'a',
            /* testMatchArrowInLongArrayValue2 */
            2 => 'b'
        },
        /* testLongArrayArrowWithNestedMatchValue2 */
        $i  => match ($test) {
            /* testMatchArrowInLongArrayValue3 */
            1 => 'a',
        },
    ];
}

function matchNestedInShortArrayValue()
{

    $array = [
        /* testShortArrayArrowWithNestedMatchValue1 */
        'a' => match ($test) {
            /* testMatchArrowInShortArrayValue1 */
            1 => 'a',
            /* testMatchArrowInShortArrayValue2 */
            2 => 'b'
        },
        /* testShortArrayArrowWithNestedMatchValue2 */
        $i  => match ($test) {
            /* testMatchArrowInShortArrayValue3 */
            1 => 'a',
        },
    ];
}

function matchNestedInLongArrayKey()
{

    $array = [
        match ($test) { /* testMatchArrowInLongArrayKey1 */
            1 => 'a', /* testMatchArrowInLongArrayKey2 */
            2 => 'b'
        }
        /* testLongArrayArrowWithMatchKey */
        => 'dynamic keys, woho!',
    ];
}

function matchNestedInShortArrayKey()
{

    $array = [
        match ($test) { /* testMatchArrowInShortArrayKey1 */
            1 => 'a', /* testMatchArrowInShortArrayKey2 */
            2 => 'b'
        }
        /* testShortArrayArrowWithMatchKey */
        => 'dynamic keys, woho!',
    ];
}

function arraysNestedInMatch()
{

    $matcher = match ($x) {
        /* testMatchArrowWithLongArrayBodyWithKeys */
        0 => [
            /* testLongArrayArrowInMatchBody1 */
            0   => 1,
            /* testLongArrayArrowInMatchBody2 */
            'a' => 2,
            /* testLongArrayArrowInMatchBody3 */
            'b' => 3,
        ],
        /* testMatchArrowWithShortArrayBodyWithoutKeys */
        1 => [1, 2, 3],
        /* testMatchArrowWithLongArrayBodyWithoutKeys */
        2 => [1, [1, 2, 3], 2, 3],
        /* testMatchArrowWithShortArrayBodyWithKeys */
        3 => [
            /* testShortArrayArrowInMatchBody1 */
            0   => 1,
            /* testShortArrayArrowInMatchBody2 */
            'a' => [1, 2, 3],
            /* testShortArrayArrowInMatchBody3 */
            'b' => 2,
            3,
        ],
        /* testShortArrayArrowinMatchCase1 */
        [
            4 => 'a', /* testShortArrayArrowinMatchCase2 */
            5 => 6,
        ]
            /* testMatchArrowWithShortArrayWithKeysAsCase */
          => 'match with array as case value',
        /* testShortArrayArrowinMatchCase3 */
        [4 => 'a'], /* testLongArrayArrowinMatchCase4 */
        [5 => 6],
            /* testMatchArrowWithMultipleArraysWithKeysAsCase */
          => 'match with multiple arrays as case value',
    };
}

function matchNestedInArrowFunction($x)
{

    /* testFnArrowWithMatchInValue */
    $fn = fn($x) => match (true) {
        /* testMatchArrowInFnBody1 */
        1, 2, 3, 4, 5 => 'foo',
        /* testMatchArrowInFnBody2 */
        default       => 'bar',
    };
}

function arrowFunctionsNestedInMatch($x)
{

    return match ($x) {
        /* testMatchArrowWithFnBody1 */
        1       => /* testFnArrowInMatchBody1 */ fn($y) => callMe($y),
        /* testMatchArrowWithFnBody2 */
        default => /* testFnArrowInMatchBody2 */ fn($y) => callThem($y)
    };
}

function matchShortArrayMismash()
{

    $array = [
        match ($test) {
            /* testMatchArrowInComplexShortArrayKey1 */
            1 => [ /* testShortArrayArrowInComplexMatchValueinShortArrayKey */
                   1 => 'a',
            ],
            /* testMatchArrowInComplexShortArrayKey2 */
            2 => 'b'
            /* testShortArrayArrowInComplexMatchArrayMismash */
        } => match ($test) {
            /* testMatchArrowInComplexShortArrayValue1 */
            1 => [ /* testShortArrayArrowInComplexMatchValueinShortArrayValue */
                   1 => 'a',
            ],
            /* testMatchArrowInComplexShortArrayValue2 */
            2 => /* testFnArrowInComplexMatchValueInShortArrayValue */
            fn($y) => callMe($y)
        },
    ];
}

function longListInMatch($x, $y)
{

    return match ($x) {
        /* testMatchArrowWithLongListBody */
        1                                                                      => list('a' => $a, /* testLongListArrowInMatchBody */ 'b' => $b, 'c' => list('d' => $c)) = $y,
        /* testLongListArrowInMatchCase */
        list('a' => $a, 'b' => $b) = $y /* testMatchArrowWithLongListInCase */ => 'something'
    };
}

function shortListInMatch($x, $y)
{

    return match ($x) {
        /* testMatchArrowWithShortListBody */
        1                                                                   => ['a' => $a, 'b' => $b, 'c' => /* testShortListArrowInMatchBody */ ['d' => $c]] = $y,
        /* testShortListArrowInMatchCase */
        ['a' => $a, 'b' => $b] = $y /* testMatchArrowWithShortListInCase */ => 'something'
    };
}

function matchInLongList()
{

    /* testMatchArrowInLongListKey */
    [
        match ($x) {
            1 => 1,
            2 => 2
        } /* testLongListArrowWithMatchInKey */ => $a,
    ] = $array;
}

function matchInShortList()
{

    /* testMatchArrowInShortListKey */
    [
        match ($x) {
            1 => 1,
            2 => 2
        } /* testShortListArrowWithMatchInKey */ => $a,
    ] = $array;
}

function longArrayWithConstantKey()
{

    $arr = [
        /* testLongArrayArrowWithClassConstantKey */
        SomeClass::DEFAULT => 1,
    ];
}

function shortArrayWithConstantKey()
{

    $arr = [
        /* testShortArrayArrowWithClassConstantKey */
        SomeClass::DEFAULT => 1,
    ];
}

function yieldWithConstantKey()
{

    /* testYieldArrowWithClassConstantKey */
    yield SomeClass::DEFAULT => 1;
}

function longArrayWithConstantKeyNestedInMatch()
{

    return match ($x) {
        /* testMatchArrowWithNestedLongArrayWithClassConstantKey */
        default => [
            /* testLongArrayArrowWithClassConstantKeyNestedInMatch */
            SomeClass::DEFAULT => 1,
        ],
    };
}

function shortArrayWithConstantKeyNestedInMatch()
{

    return match ($x) {
        /* testMatchArrowWithNestedShortArrayWithClassConstantKey */
        default => [
            /* testShortArrayArrowWithClassConstantKeyNestedInMatch */
            SomeClass::DEFAULT => 1,
        ],
    };
}

function longArrayWithConstantKeyWithNestedMatch()
{

    return [
        /* testLongArrayArrowWithClassConstantKeyWithNestedMatch */
        SomeClass::DEFAULT => match ($x) {
            /* testMatchArrowNestedInLongArrayWithClassConstantKey */
            default => 'foo'
        },
    ];
}

function shortArrayWithConstantKeyWithNestedMatch()
{

    return [
        /* testShortArrayArrowWithClassConstantKeyWithNestedMatch */
        SomeClass::DEFAULT => match ($x) {
            /* testMatchArrowNestedInShortArrayWithClassConstantKey */
            default => 'foo'
        },
    ];
}
