<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: SelfMemberReferenceUnitTest.inc
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

class SelfMemberReferenceUnitTestExample
{

    private $testCount = 0;

    private $testResults = [];

    public function SelfMemberReferenceUnitTestExample()
    {

        $testResults =& $this->testResults;

        // Correct call to self.
        $testResults[] = self::selfMemberReferenceUnitTestFunction();
        $testResults[] = parent::selfMemberReferenceUnitTestFunction();

        // Incorrect case.
        $testResults[] = Self::selfMemberReferenceUnitTestFunction();
        $testResults[] = SELF::selfMemberReferenceUnitTestFunction();
        $testResults[] = SelfMemberReferenceUnitTestExample::selfMemberReferenceUnitTestFunction();

        // Incorrect spacing.
        $testResults[] = self::selfMemberReferenceUnitTestFunction();
        $testResults[] = self::  selfMemberReferenceUnitTestFunction();
        $testResults[] = self:: selfMemberReferenceUnitTestFunction();

        // Remove ALL the newlines
        $testResults[] = self
            ::




            selfMemberReferenceUnitTestFunction();
    }

    public function selfMemberReferenceUnitTestFunction()
    {

        $this->testCount = $this->testCount + 1;

        return $this->testCount;
    }

}

class MyClass {

    public static function test($value) {
        echo "$value\n";
    }

    public static function walk() {
        $callback = function($value, $key) {
                        // This is valid because you can't use self:: in a closure.
                        MyClass::test($value);
                    };

        $array = array(1,2,3);
        array_walk($array, $callback);
    }
}

MyClass::walk();

class Controller
{
    public function Action()
    {
        Doctrine\Common\Util\Debug::dump();
    }
}

class Foo
{
    public static function bar()
    {
        Foo::baz();
    }
}

namespace TYPO3\CMS\Reports;

class Status {

    public const NOTICE = -2;
    public const INFO   = -1;
    public const OK   = 0;
    public const WARNING = 1;
    public const ERROR   = 2;
}

namespace TYPO3\CMS\Reports\Report\Status;

use TYPO3\CMS\Reports\ReportInterface;

class Status implements ReportInterface {
    public function getHighestSeverity(array $statusCollection) {
        $highestSeverity = \TYPO3\CMS\Reports\Status::NOTICE;
    }
}

namespace Foo;

class Bar
{

    public function myFunction()
    {

        Whatever::something();
        Bar::something();
    }

}

namespace Foo\Bar;

class Baz
{

    public function myFunction()
    {

        Whatever::something();
        Baz::something();
    }

}

class Nested_Anon_Class {
    public function getAnonymousClass() {
        // Spacing/comments should not cause false negatives for the NotUsed error.
        Nested_Anon_Class      ::       $prop;
        Nested_Anon_Class
        /* some comment */

        ::

        // phpcs:ignore Standard.Category.SniffName -- for reasons.
        Bar();

        // Anonymous class is a different scope.
        return new class() {
            public function nested_function() {
                Nested_Anon_Class::$prop;
                Nested_Anon_Class::BAR;
            }
        };
    }
}

// Test dealing with scoped namespaces.
namespace Foo\Baz {
    class BarFoo {
        public function foo() {
            echo Foo\Baz\BarFoo::$prop;
        }
    }
}

// Prevent false negative when namespace has whitespace/comments.
namespace Foo /*comment*/ \ Bah {
    class BarFoo {
        public function foo() {
            echo Foo \ /*comment*/ Bah\BarFoo::$prop;
        }
    }
}
