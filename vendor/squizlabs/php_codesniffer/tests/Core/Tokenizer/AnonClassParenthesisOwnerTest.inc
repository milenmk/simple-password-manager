<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: AnonClassParenthesisOwnerTest.inc
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

/* testNoParentheses */
$anonClass = new class {

    public function __construct() {}

};

/* testNoParenthesesAndEmptyTokens */
$anonClass = new class // phpcs:ignore Standard.Cat {

    function __construct() {}

}

/* testWithParentheses */
$anonClass = new class() {

};

/* testWithParenthesesAndEmptyTokens */
$anonClass = new class /*comment */
() {

};
