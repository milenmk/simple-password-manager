<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: StableCommentWhitespaceWinTest.inc
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

/* testSingleLineSlashComment */
// Comment

/* testSingleLineSlashCommentTrailing */
echo 'a'; // Comment

/* testSingleLineSlashAnnotation */
// phpcs:disable Stnd.Cat

/* testMultiLineSlashComment */
// Comment1
// Comment2
// Comment3

/* testMultiLineSlashCommentWithIndent */
// Comment1
// Comment2
// Comment3

/* testMultiLineSlashCommentWithAnnotationStart */
// phpcs:ignore Stnd.Cat
// Comment2
// Comment3

/* testMultiLineSlashCommentWithAnnotationMiddle */
// Comment1
// @phpcs:ignore Stnd.Cat
// Comment3

/* testMultiLineSlashCommentWithAnnotationEnd */
// Comment1
// Comment2
// phpcs:ignore Stnd.Cat

/* testSingleLineSlashCommentNoNewLineAtEnd */
// Slash ?>
<?php

/* testSingleLineHashComment */

# Comment

/* testSingleLineHashCommentTrailing */
echo 'a'; # Comment

/* testMultiLineHashComment */
# Comment1
# Comment2
# Comment3

/* testMultiLineHashCommentWithIndent */
# Comment1
# Comment2
# Comment3

/* testSingleLineHashCommentNoNewLineAtEnd */
# Hash ?>
<?php

/* testCommentAtEndOfFile */
/* Comment