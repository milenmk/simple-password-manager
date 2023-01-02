<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: GitMergeConflictUnitTest.6.inc
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

$string =
		<<<"EOD"
		Merge conflicts in PHP 7.3 indented heredocs
<<<<<<< HEAD
		can be problematic.
=======
		should also be detected.
>>>>>>> ref/heads/other-branchname
		And now they are.
		EOD;

// Break the tokenizer.
>>>>>>> master

/*
 * The above tests are based on "normal" tokens.
 * The below test checks that once the tokenizer breaks down because of
 * unexpected merge conflict boundaries - i.e. after the first merge conflict
 * opener in non-comment, non-heredoc/nowdoc, non-inline HTML code -, subsequent
 * merge conflict boundaries will still be detected correctly.
 */

$string =
		<<<"EOD"
		Merge conflicts in PHP 7.3 indented heredocs
<<<<<<< HEAD
		can be problematic.
=======
		should also be detected.
>>>>>>> ref/heads/other-branchname
		And now they are.
		EOD;
