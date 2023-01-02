<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ControlStructureSpacingUnitTest.inc
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

while ( $expr ) {
}

if (
) {
}

while (
    $expr1
    && $expr2
) {
}

while (
$expr1
  && $expr2
    ) {
}

do {
} while ($expr1
    && $expr2) {
}

if (
    $expr1
        && $expr2
    && $expr3
) {
    while (
$expr1
  && $expr2
) {
    }
    while (
    $expr1
      && $expr2
        ) {
    }
}

while (
    $expr1
    && $expr2


        ) {
}

while (
    $expr1
    && $expr2
    // comment here
) {
}

for ($i = 0;
$i < 10;
    $i++;
) {
}

if (
    foo(
            'this
            is a
            string',
            <<<EOD
foobar!
EOD
        )
) {
    return;
}

    if (
        isset($foo) === true
        && $bar > $foo
        /*
         * A multi-line comment.
         */
        && $foo === true
    ) {
        break;
    }

match (
    $expr1 &&
    $expr2 &&
    $expr3
    ) {
    // structure body
};

match ($expr1 &&
$expr2 &&
  $expr3) {
      // structure body
};
