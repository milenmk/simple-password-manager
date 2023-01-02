<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: MethodDeclarationUnitTest.inc
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

class MyClass
{

    public function _myFunction() {}

    private function myFunction() {}

    public function __myFunction() {}

    public static function myFunction() {}

    public static /*comment*/ function myFunction() {}

    final public function myFunction() {}

    final public function myFunction() {}

    abstract private function myFunction();

    abstract private function myFunction();

    final public /*comment*/ static function myFunction() {}

    abstract final protected static function myFunction();

    public function _() {}

}

interface MyInterface
{

    public function _myFunction();

    public function __myFunction();

    public static function myFunction();

    public static function myFunction();

    public function _();

}

trait MyTrait
{

    public function _myFunction() {}

    private function myFunction() {}

    public function __myFunction() {}

    public static function myFunction() {}

    public static function myFunction() {}

    final /*comment*/ public function myFunction() {}

    final public function myFunction() {}

    abstract private function myFunction();

    abstract private function myFunction();

    final public static function myFunction() {}

    abstract final protected static function myFunction();

    public function _() {}

}

$a = new class() {

    public function _myFunction() {}

    private function myFunction() {}

    public function __myFunction() {}

    public static function myFunction() {}

    public static function myFunction() {}

    final public function myFunction() {}

    final public function myFunction() {}

    abstract private function myFunction();

    abstract private function myFunction();

    final public static function myFunction() {}

    abstract final protected static function myFunction();

    public function _() {}

}

class Nested_Function {
    public function getAnonymousClass() {
        return new class() {
			final private static function _nested_function() {}
        };
    }
}

enum MyEnum
{

    public function _myFunction() {}

    public function __myFunction() {}

    public static function myFunction() {}

    public static function myFunction() {}

    public function _() {}

}
