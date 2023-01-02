<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: MethodScopeUnitTest.inc
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

function func1() {}

class MyClass
{

    public function func1() {}

    public function func1() {}

    private function func1() {}

    protected function func1() {}

}

class Closure_Test {
    public function test() {
        $foo = function() { echo 'foo'; };

        function my_sort() {
            // ...
        }

        $a = array();
        usort($a, 'my_sort');
    }
}

function test() {
    $foo = function() { echo 'foo'; };
}

trait Trait_Test
{

    public function func1() {}

    public function func1() {}

    private function func1() {}

    protected function func1() {}

}

class Nested {
    public function getAnonymousClass() {
        return new class() {

            public function __something() {}

        };
    }
}

enum SomeEnum
{

    public function func1() {}

    public function func1() {}

    private function func1() {}

    protected function func1() {}

}

class UnconventionalSpacing {
    public
    static
    function
    myFunction() {}
}
