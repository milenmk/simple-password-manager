<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DisallowInlineIfUnitTest.inc
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

if ($var1) {
    $var2 = 0;
} else {
    $var2 = 1;
}

$var1 ? $var2 = 0 : $var2 = 1;

function foo(string $bar, array $baz, ?MyClass $object) : MyClass {}

class Example {
    public ?int $scalarType;
}

$a = fn(?DateTime $x) : ?DateTime => $x;

$b = fn ($b) => $b ? true : false;
