<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DefaultKeywordTest.inc
 *  Last Modified: 3.01.23 г., 0:07 ч.
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

function matchWithDefault($i)
{

    return match ($i) {
        1       => 1,
        2       => 2,
        /* testSimpleMatchDefault */
        default => 'default',
    };
}

function switchWithDefault($i)
{

    switch ($i) {
        case 1:
            return 1;
        case 2:
            return 2;
        /* testSimpleSwitchDefault */
        default:
            return 'default';
    }
}

function switchWithDefaultAndCurlies($i)
{

    switch ($i) {
        case 1:
            return 1;
        case 2:
            return 2;
        /* testSimpleSwitchDefaultWithCurlies */
        default:
        {
            return 'default';
        }
    }
}

function matchWithDefaultInSwitch()
{

    switch ($something) {
        case 'foo':
            $var = [1, 2, 3];
            $var = match ($i) {
                1       => 1,
                /* testMatchDefaultNestedInSwitchCase1 */
                default => 'default',
            };
            continue;

        case 'bar' :
            $i = callMe($a, $b);

            return match ($i) {
                1       => 1,
                /* testMatchDefaultNestedInSwitchCase2 */
                default => 'default',
            };

        /* testSwitchDefault */
        default;
            echo 'something', match ($i) {
                1,       => 1,
                /* testMatchDefaultNestedInSwitchDefault */
                default, => 'default',
            };
            break;
    }
}

function switchWithDefaultInMatch()
{

    $x = match ($y) {
        5, 8    => function ($z) {

            switch ($z) {
                case 'a';
                    $var = [1, 2, 3];

                    return 'a';
                /* testSwitchDefaultNestedInMatchCase */
                default:
                    $var = [1, 2, 3];

                    return 'default1';
            }
        },
        /* testMatchDefault */
        default => function ($z) {

            switch ($z) {
                case 'a':
                    $i = callMe($a, $b);

                    return 'b';
                /* testSwitchDefaultNestedInMatchDefault */
                default:
                    $i = callMe($a, $b);

                    return 'default2';
            }
        }
    };
}

function shortArrayWithConstantKey()
{

    $arr = [
        /* testClassConstantAsShortArrayKey */
        SomeClass::DEFAULT    => 1,
        /* testClassPropertyAsShortArrayKey */
        SomeClass->DEFAULT    => 1,
        /* testNamespacedConstantAsShortArrayKey */
        // Intentional parse error PHP < 8.0. Reserved keyword used as namespaced constant.
        SomeNamespace\DEFAULT => 1,
        /* testFQNGlobalConstantAsShortArrayKey */
        // Intentional parse error in PHP < 8.0. Reserved keyword used as global constant.
        \DEFAULT              => 1,
    ];
}

function longArrayWithConstantKey()
{

    $arr = [
        /* testClassConstantAsLongArrayKey */
        SomeClass::DEFAULT => 1,
    ];
}

function yieldWithConstantKey()
{

    /* testClassConstantAsYieldKey */
    yield SomeClass::DEFAULT => 1;
}

function longArrayWithConstantKeyNestedInMatch()
{

    return match ($x) {
        /* testMatchDefaultWithNestedLongArrayWithClassConstantKey */
        default => [
            /* testClassConstantAsLongArrayKeyNestedInMatch */
            SomeClass::DEFAULT => match ($x) {
                /* testMatchDefaultWithNestedLongArrayWithClassConstantKeyLevelDown */
                default => [
                    /* testClassConstantAsLongArrayKeyNestedInMatchLevelDown */
                    SomeClass::DEFAULT => 1,
                ],
            },
        ],
    };
}

function shortArrayWithConstantKeyNestedInMatch()
{

    return match ($x) {
        /* testMatchDefaultWithNestedShortArrayWithClassConstantKey */
        default => [
            /* testClassConstantAsShortArrayKeyNestedInMatch */
            SomeClass::DEFAULT => match ($x) {
                /* testMatchDefaultWithNestedShortArrayWithClassConstantKeyLevelDown */
                default => [
                    /* testClassConstantAsShortArrayKeyNestedInMatchLevelDown */
                    SomeClass::DEFAULT => 1,
                ],
            },
        ],
    };
}

function longArrayWithConstantKeyWithNestedMatch()
{

    return [
        /* testClassConstantAsLongArrayKeyWithNestedMatch */
        SomeClass::DEFAULT => match ($x) {
            /* testMatchDefaultNestedInLongArray */
            default => 'foo'
        },
    ];
}

function shortArrayWithConstantKeyWithNestedMatch()
{

    return [
        /* testClassConstantAsShortArrayKeyWithNestedMatch */
        SomeClass::DEFAULT => match ($x) {
            /* testMatchDefaultNestedInShortArray */
            default => 'foo'
        },
    ];
}

function switchWithConstantNonDefault($i)
{

    switch ($i) {
        /* testClassConstantInSwitchCase */
        case SomeClass::DEFAULT:
            return 1;

        /* testClassPropertyInSwitchCase */
        case SomeClass->DEFAULT:
            return 2;

        /* testNamespacedConstantInSwitchCase */
        // Intentional parse error PHP < 8.0. Reserved keyword used as constant.
        case SomeNamespace\DEFAULT:
            return 2;

        /* testNamespaceRelativeConstantInSwitchCase */
        // Intentional parse error PHP < 8.0. Reserved keyword used as global constant.
        case namespace\DEFAULT:
            return 2;
    }
}

class Foo
{

    /* testClassConstant */
    public const DEFAULT = 'foo';

    /* testMethodDeclaration */
    public function default() {}

}
