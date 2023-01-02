<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: BackfillExplicitOctalNotationTest.inc
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

/* testExplicitOctal */
$foo = 0o137041;

/* testExplicitOctalCapitalised */
$bar = 0O137041;

/* testExplicitOctalWithNumericSeparator */
$octal = 0o137_041;

/* testInvalid1 */
$foo = 0o_137;

/* testInvalid2 */
$foo = 0O_41;

/* testInvalid3 */
$foo = 0o91;

/* testInvalid4 */
$foo = 0O282;

/* testInvalid5 */
$foo = 0o28_2;

/* testInvalid6 */
$foo = 0o2_82;
