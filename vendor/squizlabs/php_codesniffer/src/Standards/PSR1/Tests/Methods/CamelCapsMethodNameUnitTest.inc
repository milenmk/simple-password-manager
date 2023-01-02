<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: CamelCapsMethodNameUnitTest.inc
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

    private function getSomeValue() {}

    private function parseMyDSN() {}

    private function get_some_value() {}

    public function getSomeValue() {}

    public function parseMyDSN() {}

    public function get_some_value() {}

    public function o_toString() {}

}//end class

function getSomeValue() {}
function parseMyDSN() {}
function get_some_value() {}

class Closure_Test
{

    public function test()
    {

        $foo = function () {

            echo 'foo';
        };
    }

}

trait Foo
{

    public function __call() {}

}

class Magic_Case_Test
{

    public function __Construct() {}

    public function __isSet() {}

    public function __tostring() {}

    public function __set_state() {}

}
function __autoLoad() {}

class Foo extends SoapClient
{

    public function __soapCall(
        $functionName,
        $arguments,
        $options = [],
        $inputHeaders = null,
        &$outputHeaders = []
    )
    {
        // body
    }

    public function __() {}

}

function ___tripleUnderscore() {} // Ok.

class triple {
    public function ___tripleUnderscore() {} // Ok.
}

class Nested {
    public function getAnonymousClass() {
        return new class() {
            public function nested_function() {}
        };
    }
}

