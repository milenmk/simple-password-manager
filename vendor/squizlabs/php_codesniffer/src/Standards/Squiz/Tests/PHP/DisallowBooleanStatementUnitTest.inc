<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DisallowBooleanStatementUnitTest.inc
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

trySomething() || trySomethingElse();
if (trySomething() === FALSE) {
    trySomethingElse();
}

$success || fail();
if ($success === FALSE) {
    fail();
}

$foo = ($bar || $foo);

doSomething() || die();

if ($something || somethingElse()) {
    while ($foo && $bar) {
    }

    do {
        // Code here.
    }
    while ($foo && $bar);
}

?>