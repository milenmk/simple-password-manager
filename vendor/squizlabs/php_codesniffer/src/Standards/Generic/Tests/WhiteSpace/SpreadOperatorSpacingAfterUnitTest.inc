<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: SpreadOperatorSpacingAfterUnitTest.inc
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

function foo( &...$spread ) {
    bar( ...$spread );

    bar(
        [ ...$foo ],
        ...array_values($keyedArray)
    );
}

function bar( &   ... $spread ) {
    bar(...


        $spread
    );

    bar(
        [...  $foo ],.../*comment*/array_values($keyedArray)
    );
}

// phpcs:set Generic.WhiteSpace.SpreadOperatorSpacingAfter ignoreNewlines true
    bar(...
        $spread
    );
// phpcs:set Generic.WhiteSpace.SpreadOperatorSpacingAfter ignoreNewlines false

// phpcs:set Generic.WhiteSpace.SpreadOperatorSpacingAfter spacing 1
function foo( &... $spread ) {
    bar( ... $spread );

    bar(
        [ ... $foo ],
        ... array_values($keyedArray)
    );
}

function bar( &   ...$spread ) {
    bar(...
        $spread
    );

    bar(
        [...  $foo ],.../*comment*/array_values($keyedArray)
    );
}

// phpcs:set Generic.WhiteSpace.SpreadOperatorSpacingAfter spacing 2
function foo( &...  $spread ) {
    bar( ...  $spread );

    bar(
        [ ...  $foo ],
        ...  array_values($keyedArray)
    );
}

function bar( &   ... $spread ) {
    bar(...
        $spread
    );

    bar(
        [...    $foo ],.../*comment*/array_values($keyedArray)
    );
}

// phpcs:set Generic.WhiteSpace.SpreadOperatorSpacingAfter spacing 0

// Intentional parse error. This has to be the last test in the file.
function bar( ...
