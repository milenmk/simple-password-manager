<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DisallowLongArraySyntaxUnitTest.2.inc
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

$var = array();

// The following function has a simulated git conflict for testing.
// This is not a merge conflict - it is a valid test case to test handling of arrays without associated closer.
// Please do not remove.
function test()
    {
        $arr = array(
            'a' => 'a',
<<<<<<< HEAD
            'b' => 'b'
=======
            'c' => 'c'
>>>>>>> master
        );
    }
