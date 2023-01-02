<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ShortFormTypeKeywordsUnitTest.inc
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

$bar = (bool) $foo;
$bar = (boolean) $foo;
$bar = (Bool) $foo;
$bar = (BOOLEAN) $foo;
$bar = (int) $foo;
$bar = (integer) $foo;
$bar = (INT) $foo;

// Test recognition with whitespace within the cast.
$bar = (  bool  ) $foo;
$bar = ( int ) $foo;
$bar = (     boolean   	    ) $foo;
$bar = (  integer) $foo;
