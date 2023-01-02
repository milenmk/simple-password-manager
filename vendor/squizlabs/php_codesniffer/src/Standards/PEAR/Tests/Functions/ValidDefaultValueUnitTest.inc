<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ValidDefaultValueUnitTest.inc
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

// No args.
function myFunction()
{
}

// No default args.
function myFunction($arg1)
{
}

// Valid
function myFunction($arg1, $arg2='hello')
{
}

// Valid with lots of args
function myFunction($arg1, $arg2, $arg3, $arg4='hello', $arg5=array(), $arg6='hello')
{
}

// Valid type hints
function myFunction(array $arg1, array $arg2=array())
{
}

// Invalid
function myFunction($arg2='hello', $arg1)
{
}

// Invalid with lots of args
function myFunction($arg1, $arg2, $arg3, $arg4='hello', $arg5, $arg6='hello')
{
}

// Invalid type hints
function myFunction(array $arg2=array(), array $arg1)
{
}

class myClass
{

    // No args.
    public function myFunction() {}

    // No default args.
    public function myFunction($arg1) {}

    // Valid
    public function myFunction($arg1, $arg2 = 'hello') {}

    // Valid with lots of args
    public function myFunction($arg1, $arg2, $arg3, $arg4 = 'hello', $arg5 = [], $arg6 = 'hello') {}

    // Valid type hints
    public function myFunction(array $arg1, array $arg2 = []) {}

    // Invalid
    public function myFunction($arg2 = 'hello', $arg1) {}

    // Invalid with lots of args
    public function myFunction($arg1, $arg2, $arg3, $arg4 = 'hello', $arg5, $arg6 = 'hello') {}

    // Invalid type hints
    public function myFunction(array $arg2 = [], array $arg1) {}

}

function myFunc($req, $opt=null, ...$params) {}

// Type hinting with NULL
function foo(Foo $foo = null, $bar) {}
function foo(Foo $foo, $bar) {}
function foo(Foo $foo = null, $bar = true, $baz) {}
function foo($baz, Foo $foo = null, $bar = true) {}
function foo($baz, $bar = true, Foo $foo = null) {}

// Valid closure
$closure = function ($arg1, $arg2='hello') {};

// Invalid closure
$closure = function(array $arg2=array(), array $arg1) {}

$fn = fn($a = [], $b) => $a[] = $b;

class OnlyConstructorPropertyPromotion {
    public function __construct(
        public string $name = '',
        protected $bar
    ) {}
}

class ConstructorPropertyPromotionMixedWithNormalParams {
    public function __construct(
        public string $name = '',
        ?int $optionalParam = 0,
        mixed $requiredParam,
    ) {}
}

// Intentional syntax error. Must be last thing in the file.
function
