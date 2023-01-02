<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: OpeningFunctionBraceBsdAllmanUnitTest.inc
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

// Brace should be on new line.
function myFunction() {
}

// Good.
function myFunction()
{
}

// Too many spaces.
function myFunction()   {
}

// Too many newlines.
function myFunction()

{
}

// Space before brace.
function myFunction()
 {
}

class myClass
{

    // Brace should be on new line.
    public function myFunction() {}

    // Good.
    public function myFunction() {}

    // No aligned correctly.
    public function myFunction() {}

    // Too many spaces.
    public function myFunction() {}

    // Too many newlines.
    public function myFunction() {}

    // Space before brace.
    public function myFunction() {}

}



/* Multi-line declarations */



// Brace should be on new line.
function myFunction($variable1, $variable2,
    $variable3, $variable4) {
}

// Good.
function myFunction($variable1, $variable2,
    $variable3, $variable4)
{
}

// Too many spaces.
function myFunction($variable1, $variable2,
    $variable3, $variable4)   {
}

// Too many newlines.
function myFunction($variable1, $variable2,
    $variable3, $variable4)

{
}

// Space before brace.
function myFunction($variable1, $variable2,
    $variable3, $variable4)
 {
}

class myClass
{

    // Brace should be on new line.
    public function myFunction($variable1, $variable2,
                               $variable3, $variable4) {}

    // Good.
    public function myFunction($variable1, $variable2,
                               $variable3, $variable4) {}

    // No aligned correctly.
    public function myFunction($variable1, $variable2,
                               $variable3, $variable4) {}

    // Too many spaces.
    public function myFunction($variable1, $variable2,
                               $variable3, $variable4) {}

    // Too many newlines.
    public function myFunction($variable1, $variable2,
                               $variable3, $variable4) {}

    // Space before brace.
    public function myFunction($variable1, $variable2,
                               $variable3, $variable4) {}

}

interface MyInterface
{

    public function myFunction();

}

function myFunction(
                    $arg1,
                    $arg2,
                    $arg3,
                    $arg4,
                    $arg5,
                    $arg6
                    )
{
}

function myFunction(
                    $arg1,
                    $arg2,
                    $arg3,
                    $arg4,
                    $arg5,
                    $arg6
                    ) {
}

function myFunction() {}
function myFunction()
{}

// phpcs:set Generic.Functions.OpeningFunctionBraceBsdAllman checkClosures 1

$closureWithArgs = function ($arg1, $arg2) {
    // body
};

$closureWithArgsAndVars = function ($arg1, $arg2) use ($var1, $var2) {
    // body
};

$test = function ($param) use ($result) {
    return null;
};

$test = function ($param) use ($result) : Something {
    return null;
};

// phpcs:set Generic.Functions.OpeningFunctionBraceBsdAllman checkClosures 0

$closureWithArgs = function ($arg1, $arg2) {
    // body
};

class Foo
{
//Comments should not affect code
    public function bar()
    {

    }
//Comments should not affect code
}

function myFunction() : Something {
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array {
    return null;
}

function myFunction($a, $lot, $of, $params) { // comment
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array { // comment
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array { // phpcs:ignore Standard.Category.Sniff -- for reasons.
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array {// phpcs:ignore Standard.Category.Sniff -- for reasons.
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array
{ // phpcs:ignore Standard.Category.Sniff -- for reasons.
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array /* phpcs:ignore Standard.Category.Sniff -- for reasons */ {
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array /* comment */ {
    return null;
}

class Issue3357
{
    public function extraLine(string: $a): void

    {
        // code here.
    }
}

function issue3357WithoutIndent(string: $a): void


{
    // code here.
}

class Issue3357WithComment
{
    public function extraLine(string: $a): void
    // Comment.
    {
        // code here.
    }
}
