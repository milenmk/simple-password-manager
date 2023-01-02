<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: EmptyCatchCommentUnitTest.inc
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

try {
    // Try something.
    $variable = 'string';
} catch (Exception $e) {
    // Comment.
    echo 'something broke';
}

try {
    // Try something.
    $variable = 'string';
} catch (Exception $e) {
}

try {
    // Try something.
    $variable = 'string';
} catch (Exception $e) {
    // Dont want to do anything.
}

try {
    $variable = 'string';
} catch (MyException $e) {
    echo 'something broke';
} catch (Exception $e) {
    echo 'something broke';
}

try {
    $variable = 'string';
} catch (MyException $e) {

} catch (Exception $e) {
    echo 'something broke';
}

try {
    $variable = 'string';
} catch (MyException $e) {
    // Dont do anything.
} catch (Exception $e) {
    // Do nothing.
}

try {
    $variable = 'string';
} catch (MyException $e) {
} catch (YourException $e) {
} catch (OurException $e) {
} catch (Exception $e) {
}

?>