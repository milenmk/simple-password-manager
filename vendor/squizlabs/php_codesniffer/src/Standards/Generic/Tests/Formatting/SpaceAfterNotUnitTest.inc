<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: SpaceAfterNotUnitTest.inc
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

if (! $someVar || ! $x instanceOf stdClass) {}
if (!$someVar || !$x instanceOf stdClass) {}
if (!     $someVar || !   $x instanceOf stdClass) {}
if (!foo() && (!$x || true)) {}
$var = !($x || $y);
$var = !           ($x || $y);
$var = ! /*comment*/ ($x || $y);

$baz = function () {
    return !  $bar;
};

if ( !
    ($x || $y)
) {
    return !$bar;
}

if ( ! // phpcs:ignore Standard.Cat.SniffName -- for reasons.
    ($x || $y)
) {}

// phpcs:set Generic.Formatting.SpaceAfterNot ignoreNewlines true
if ( !
    ($x || $y)
) {
    return !$bar;
}

if ( ! // phpcs:ignore Standard.Cat.SniffName -- for reasons.
    ($x || $y)
) {}
// phpcs:set Generic.Formatting.SpaceAfterNot ignoreNewlines false

// phpcs:set Generic.Formatting.SpaceAfterNot spacing 2
if (!  $someVar || !  $x instanceOf stdClass) {}
if (!$someVar || !$x instanceOf stdClass) {}
if (! $someVar || !       $x instanceOf stdClass) {}
if (!foo() && (!  $x || true)) {}
$var = ! ($x || $y);
$var = !           ($x || $y);

$baz = function () {
    return !  $bar;
};

if ( !
    ($x || $y)
) {
    return !$bar;
}

// phpcs:set Generic.Formatting.SpaceAfterNot spacing 0
if (!$someVar || !$x instanceOf stdClass) {}
if (! $someVar || !    $x instanceOf stdClass) {}
if (!   foo() && (!$x || true)) {}
$var = ! ($x || $y);
$var = ! /*comment*/ ($x || $y);

$baz = function () {
    return !  $bar;
};

if ( !
    ($x || $y)
) {
    return ! $bar;
}

if ( ! // phpcs:ignore Standard.Cat.SniffName -- for reasons.
    ($x || $y)
) {}

// phpcs:set Generic.Formatting.SpaceAfterNot ignoreNewlines true
if ( !
    ($x || $y)
) {
    return !    $bar;
}

if ( ! // phpcs:ignore Standard.Cat.SniffName -- for reasons.
    ($x || $y)
) {}
// phpcs:set Generic.Formatting.SpaceAfterNot ignoreNewlines false
// phpcs:set Generic.Formatting.SpaceAfterNot spacing 1
