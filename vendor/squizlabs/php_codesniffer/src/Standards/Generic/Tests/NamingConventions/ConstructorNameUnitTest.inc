<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ConstructorNameUnitTest.inc
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

class TestClass extends MyClass
{

    public function TestClass()
    {

        parent::MyClass();
        parent::__construct();
    }

    public function __construct()
    {

        parent::MYCLASS();
        parent::__construct();
    }

}

class MyClass
{

    public function MyClass()
    {

        parent::YourClass();
        parent::__construct();
    }

    public function __construct()
    {

        parent::YourClass();
        parent::__construct();
    }

}

class MyOtherClass extends \MyNamespace\SomeClass
{

    public function __construct()
    {

        something::MyNamespace();
    }

}

abstract class MyAbstractClass extends \MyNamespace\SomeClass
{
    abstract public function __construct();
}

class OldClass
{

    public function OldClass() {}

}

foo(new class extends MyClass {

    public function TestClass()
    {

        parent::MyClass();
        parent::__construct();
    }

    public function __construct()
    {

        parent::MyClass();
        parent::__construct();
    }

});

class OlderClass
{

    public function OlderClass() {}

    public function __CONSTRUCT() {}

}


// Issue #2178.
class Nested extends Another {
    public function getAnonymousClass() {
        return new class() extends Something {
            public function nested() {
                echo 'In method nested!';
                parent::Another(); // OK.
            }

            public function __construct() {
                parent::Another(); // OK.
            }
        };
    }

    abstract public function nested();
}

interface CustomChildCreator
{
    public function customChildCreator($elementName, Project $project);
}
