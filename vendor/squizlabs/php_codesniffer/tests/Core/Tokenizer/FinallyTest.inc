<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FinallyTest.inc
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

try {
    // Do something.
} catch(Exception $e) {
    // Do something.
}
/* testTryCatchFinally */
finally {
    // Do something.
}

/* testTryFinallyCatch */
try {
    // Do something.
} finally {
    // Do something.
} catch(Exception $e) {
    // Do something.
}

/* testTryFinally */
try {
    // Do something.
} FINALLY {
    // Do something.
}

class FinallyAsMethod {
    /* testFinallyUsedAsClassConstantName */
    const FINALLY = 'foo';

    /* testFinallyUsedAsMethodName */
    public function finally() {
        // Do something.

        /* testFinallyUsedAsPropertyName */
        $this->finally = 'foo';
    }
}
