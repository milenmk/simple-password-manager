<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: OpeningFunctionBraceKernighanRitchieUnitTest.inc
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

// Good.
function myFunction() {
}

// Brace should be on same line.
function myFunction()
{
}

// Too many spaces.
function myFunction()   {
}

// Uses tab.
function myFunction()	{
}

class myClass
{

    // Good.
    public function myFunction() {}

    // Brace should be on same line.
    public function myFunction() {}

    // Too many spaces.
    public function myFunction() {}

    // Uses tab.
    public function myFunction() {}

}



/* Multi-line declarations */

// Good.
function myFunction($variable1, $variable2,
    $variable3, $variable4) {
}

// Brace should be on same line.
function myFunction($variable1, $variable2,
    $variable3, $variable4)
{
}

// Too many spaces.
function myFunction($variable1, $variable2,
    $variable3, $variable4)   {
}

// Uses tab.
function myFunction($variable1, $variable2,
    $variable3, $variable4)	{
}

class myClass
{

    // Good.
    public function myFunction($variable1, $variable2,
                               $variable3, $variable4) {}

    // Brace should be on same line.
    public function myFunction($variable1, $variable2,
                               $variable3, $variable4) {}

    // Too many spaces.
    public function myFunction($variable1, $variable2,
                               $variable3, $variable4) {}

    // Uses tab.
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

// phpcs:set Generic.Functions.OpeningFunctionBraceKernighanRitchie checkClosures 1

$closureWithArgs = function ($arg1, $arg2){
    // body
};

$closureWithArgsAndVars = function ($arg1, $arg2) use ($var1, $var2){
    // body
};

$test = function ($param) use ($result)
{
    return null;
};

$test = function ($param) use ($result) : Something
{
    return null;
};

$test = function ($param) use ($result): Something
{
    return null;
};

foo(function ($bar) { ?>
    <div><?php echo $bar; ?></div>
<?php });

// phpcs:set Generic.Functions.OpeningFunctionBraceKernighanRitchie checkClosures 0

$closureWithArgs = function ($arg1, $arg2){
    // body
};

function myFunction() : Something
{
    return null;
}

function myFunction() : Something // Break me
{
    return null;
}

function myFunction(): Something {
    return null;
}

function myFunction(): Something
{
    return null;
}

function myFunction($bar) { ?>
    <div><?php echo $bar; ?></div>
<?php }

function myFunction($a, $lot, $of, $params)
    : array
{
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array {
    return null;
}

function myFunction($a, $lot, $of, $params) // comment
{
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array // comment
{
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array // phpcs:ignore Standard.Category.Sniff -- for reasons.
{
    return null;
}

function myFunction($a, $lot, $of, $params)
    : array { // phpcs:ignore Standard.Category.Sniff -- for reasons.
    return null;
}
