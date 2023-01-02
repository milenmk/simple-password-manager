<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: BooleanOperatorPlacementUnitTest.inc
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

if (
    $expr1
    && $expr2
    && ($expr3
    || $expr4)
    && $expr5
) {
    // if body
} elseif (
    $expr1 &&
    ($expr3 || $expr4)
    && $expr5
) {
    // elseif body
} elseif (
    $expr1
    && ($expr3 || $expr4) &&
    $expr5
) {
    // elseif body
}

if ($expr1 || $expr2) {
}

do {
} while (
    $expr1 || $expr2
    || $expr3 ||
    $expr4
);

switch (
    $expr1
    && $expr2 &&
    $expr3 || $expr4 || $expr5 && $expr6 &&
    $expr7
) {
    // structure body
}

if (
    ($n > 0 && $n < 10)
    || ($n > 10 && $n < 20)
    || ($n > 20 && $n < 30)
) {
    return $n;
}

if (
    (
        $expr1
        && $expr2
        && $expr3
        && $expr4
        && $expr5
        && $expr6
    )
    || ($n > 100 && $n < 200)
    || ($n > 200 && $n < 300)
) {
    return $n;
}

// phpcs:set PSR12.ControlStructures.BooleanOperatorPlacement allowOnly first
if (
    $expr1
    && $expr2
    && ($expr3
    || $expr4)
    && $expr5
) {
    // if body
} elseif (
    $expr1 &&
    ($expr3 || $expr4)
    && $expr5
) {
    // elseif body
} elseif (
    $expr1
    && ($expr3 || $expr4) &&
    $expr5
) {
    // elseif body
}

// phpcs:set PSR12.ControlStructures.BooleanOperatorPlacement allowOnly last
if (
    $expr1
    && $expr2
    && ($expr3
    || $expr4)
    && $expr5
) {
    // if body
} elseif (
    $expr1 &&
    ($expr3 || $expr4)
    && $expr5
) {
    // elseif body
} elseif (
    $expr1
    && ($expr3 || $expr4) &&
    $expr5
) {
    // elseif body
}

if (
    ($value == 1 ||
        $value == 2)
    &&
    ($value == 3 ||
        $value == 4)
) {
    return 5;
}

// Reset to default.
// phpcs:set PSR12.ControlStructures.BooleanOperatorPlacement allowOnly

match (
    $expr1
    && $expr2 &&
    $expr3
) {
    // structure body
};
