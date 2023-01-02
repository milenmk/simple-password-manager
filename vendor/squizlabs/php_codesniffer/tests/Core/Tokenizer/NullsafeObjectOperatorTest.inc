<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: NullsafeObjectOperatorTest.inc
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

/*
 * Null safe operator.
 */

/* testObjectOperator */
echo $obj->foo;

/* testNullsafeObjectOperator */
echo $obj?->foo;

/* testNullsafeObjectOperatorWriteContext */
// Intentional parse error, but not the concern of the tokenizer.
$foo?->bar->baz = 'baz';

/* testTernaryThen */
echo $obj ? $obj->prop : $other->prop;

/* testParseErrorWhitespaceNotAllowed */
echo $obj ?
    -> foo;

/* testParseErrorCommentNotAllowed */
echo $obj ?/*comment*/-> foo;

/* testLiveCoding */
// Intentional parse error. This has to be the last test in the file.
echo $obj?
