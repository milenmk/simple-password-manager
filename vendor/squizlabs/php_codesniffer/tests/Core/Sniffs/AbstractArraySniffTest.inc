<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: AbstractArraySniffTest.inc
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

/* testSimpleValues */
$foo = [1, 2, 3];

/* testSimpleKeyValues */
$foo = ['1' => 1, '2' => 2, '3' => 3];

/* testMissingKeys */
$foo = ['1' => 1, 2, '3' => 3];

/* testMultiTokenKeys */
$paths = [
    Init::ROOT_DIR . '/a' => 'a',
    Init::ROOT_DIR . '/b' => 'b',
];

/* testMissingKeysCoalesceTernary */

return [
    $a => static function () {

        return [1, 2, 3];
    },
    $b ?? $c,
    $d ? [$e] : [$f],
];

/* testTernaryValues */
$foo = [
    '1' => $row['status'] === 'rejected'
        ? self::REJECTED_CODE
        : self::VERIFIED_CODE,
    '2' => in_array($row['status'], ['notverified', 'unverified'], true)
        ? self::STATUS_PENDING
        : self::STATUS_VERIFIED,
    '3' => strtotime($row['date']),
];

/* testHeredocValues */
$foo = [
    <<<HERE
HERE
    ,
    <<<HERE
HERE
    ,
];

/* testArrowFunctionValue */
$foo = [
    1 => '1',
    2 => fn($x) => yield 'a' => $x,
    3 => '3',
];
