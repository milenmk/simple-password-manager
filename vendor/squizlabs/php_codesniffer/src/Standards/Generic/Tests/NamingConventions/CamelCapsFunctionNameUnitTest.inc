<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: CamelCapsFunctionNameUnitTest.inc
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

abstract class My_Class
{

    public function __construct() {}

    public function My_Class() {}

    public function _My_Class() {}

    public function getSomeValue() {}

    public function parseMyDSN() {}

    public function get_some_value() {}

    public function GetSomeValue() {}

    public function getSomeValue_Again() {}

    protected function getSomeValue() {}

    protected function parseMyDSN() {}

    protected function get_some_value() {}

    private function _getSomeValue() {}

    private function parseMyDSN() {}

    private function _get_some_value() {}

    public function getSomeValue() {}

    public function parseMyDSN() {}

    public function get_some_value() {}

}//end class

function getSomeValue() {}
function parseMyDSN() {}
function get_some_value() {}


/* Test for magic functions */

class Magic_Test
{

    public function __construct() {}

    public function __destruct() {}

    public function __call($name, $args) {}

    public static function __callStatic($name, $args) {}

    public function __get($name) {}

    public function __set($name, $value) {}

    public function __isset($name) {}

    public function __unset($name) {}

    public function __sleep() {}

    public function __wakeup() {}

    public function __toString() {}

    public function __set_state() {}

    public function __clone() {}

    public function __autoload() {}

    public function __invoke() {}

    public function __myFunction() {}

    public function __my_function() {}

}

function __construct() {}
function __destruct() {}
function __call() {}
function __callStatic() {}
function __get() {}
function __set() {}
function __isset() {}
function __unset() {}
function __sleep() {}
function __wakeup() {}
function __toString() {}
function __set_state() {}
function __clone() {}
function __autoload($class) {}
function __invoke() {}
function __myFunction() {}
function __my_function() {}

class Closure_Test
{

    public function test()
    {

        $foo = function () {

            echo 'foo';
        };
    }

}

function test() {
    $foo = function() { echo 'foo'; };
}

/* @codingStandardsIgnoreStart */
class MyClass
{
    /* @codingStandardsIgnoreEnd */
    public function __construct() {}
}

trait Foo
{

    public function __call($name, $args) {}

}

class Magic_Case_Test
{

    public function __Construct() {}

    public function __isSet($name) {}

    public function __tostring() {}

}
function __autoLoad($class) {}

class Foo extends SoapClient
{
    public function __soapCall(
        $functionName,
        $arguments,
        $options = array(),
        $inputHeaders = null,
        &$outputHeaders = array()
    ) {
        // body
    }
}

function __debugInfo() {}

class Foo
{

    public function __debugInfo() {}

}

function ___tripleUnderscore() {} // Ok.

class triple {
    public function ___tripleUnderscore() {} // Ok.
}

/* Magic methods in anonymous classes. */
$a = new class {

    public function __construct() {}

    public function __destruct() {}

    public function __call($name, $args) {}

    public static function __callStatic($name, $args) {}

    public function __get($name) {}

    public function __set($name, $value) {}

    public function __isset($name) {}

    public function __unset($name) {}

    public function __sleep() {}

    public function __wakeup() {}

    public function __toString() {}

    public function __set_state() {}

    public function __clone() {}

    public function __autoload() {}

    public function __invoke() {}

    public function __myFunction() {}

    public function __my_function() {}

};

class FooBar extends SoapClient
{
    public function __getCookies() {}
}

class Nested {
    public function getAnonymousClass() {
        return new class() {

            public function nested_function() {}

            public function __something() {}

        };
    }
}

abstract class My_Class {
    public function my_class() {}
    public function _MY_CLASS() {}
}

enum Suit: string implements Colorful, CardGame
{

    // Magic methods.
    public function __call($name, $args) {}

    public static function __callStatic($name, $args) {}

    public function __invoke() {}

    // Valid Method Name.
    public function getSomeValue() {}

    // Double underscore non-magic methods not allowed.
    public function __myFunction() {}

    public function __my_function() {}

    // Non-camelcase.
    public function parseMyDSN() {}

    public function get_some_value() {}

}
