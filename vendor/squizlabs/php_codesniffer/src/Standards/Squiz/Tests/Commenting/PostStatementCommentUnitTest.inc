<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: PostStatementCommentUnitTest.inc
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

function test()
{
    $string = 'hello';
    $string = 'hello'; // Set string to hello.
    // Valid comment.
}

function testing() // This is a function
{

}//end test()


class TestClass
{
    public $good = true; // Indeed.

}//end class

if (true || -1 == $b) { /* test */
}
$y = 10 + /* test */ -2;

$a = function() {
};//end closure

$array = [
	function($a) {
	}, // phpcs:ignore Standard.Category.SniffName -- for reasons.
	'key' => function($b) {
	}, // comment.
	'key' => 'value', // phpcs:ignore Standard.Category.SniffName -- for reasons.
	'key' => 'value', // comment.
];

// Verify that multi-line control structure with comments and annotations are left alone.
for (
    $i = 0; /* Start */
    $i < 10; /* phpcs:ignore Standard.Category.SniffName -- for reasons. */
    $i++ // comment

) {}

if ( $condition === true // comment
    && $anotherCondition === false
) {}

$match = match($foo // comment
    && $bar
) {
    1 => 1, // comment
};
