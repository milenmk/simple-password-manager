<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FunctionSpacingUnitTest.1.inc
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

/**
* Comment
*/
use Foo\{function bar, const BAZ};

use /* comment */ function bar\math\{
    Msin,
    level\Mcos as BarCos,
    Mcosh,
};

include $blah;


/**
* Comment
*/


/**
* Comment
*/
function foo()
{
}//end foo()

function func1() {

}//end func1()


function func2() {

}//end func2()

function func3() {

}//end func3()

class MyClass
{

    public function func1() {}//end func1()

    public function func2() {}//end func2()

    public function func3() {}//end func3()

}//end class

interface MyInterface
{

    public function func1();

    public function func2();

    public function func3();

}//end interface

class MyClass
{

    public function func1() {}//end func1()

    public function func2() {}//end func2()

    public function func3() {}//end func3()

}//end class

interface MyInterface
{

    public function func1();

    public function func2();

    public function func3();

}//end interface

class MyClass
{

    public function func1() {}//end func1()

}//end class

interface MyInterface
{

    public function func1();

}//end interface

class MyClass
{

    /**
     * The tag that this element represents (omitting the @ symbol).
     *
     * @var string
     */
    protected $tag = '';

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func1() {}//end func1()

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func2() {}//end func2()

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func3() {}//end func3()

}//end class

interface MyInterface
{

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func1();

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func2();

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func3();

}//end interface

class MyClass
{

    protected $tag = '';

    protected $tag = '';

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func1() {}//end func1()

}//end class

// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacing 1

interface MyInterface
{

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func1();

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func2();

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func3();

}//end interface

class MyClass
{

    protected $tag = '';

    protected $tag = '';

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func1() {}//end func1()

}//end class

// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacing 2

// Closures should be ignored.
preg_replace_callback(
    '~-([a-z])~',
    function ($match) {
        return strtoupper($match[1]);
    },
    'hello-world'
);

$callback = function ($bar) use ($foo)
            {
                $bar += $foo;
            };

class MyClass
{

    public function func1() {}

}


function test() {

}//end test()


if ($foo) {
    /**
     * Comment
     */
    function foo() {
        // Code here
    }
    /**
     * Comment
     */
    function bar() {
        // Code here
    }
}

// foo
function foo() {
}


// phpcs:disable Standard.Category.Sniff -- for reasons.
function bar() {
}


// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingBeforeFirst 0
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingAfterLast 0
class MyClass
{
    protected $tag = '';

    /**
     * Function comment.
     *
     * @return bool
     */
    private static function func1() {

    }//end func1()

    /**
     * Function comment.
     *
     * @return bool
     */
    private static function func2() {

    }//end func1()


}//end class

class MyClass
{

    public function a() {}

    public function b() {}

    public function c() {}

}

// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacing 1
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingBeforeFirst 1
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingAfterLast 1

class MyClass
{

    public function a() {}

    public function b() {}

    public function c() {}

}

$util->setLogger(new class {
    public function a(){}
    private function b(){}
    protected function c(){}
});

?>

<?php
function functionInEmbeddedPHP() {

}

// Make sure the indentation for the function comment does not get removed.
class MyClass
{

    protected $tag = '';

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func1() {}

}//end class

class MyClass
{

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func1() {}

}//end class

class MyClass
{

    // Unrelated comment.

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func1() {}
    // phpcs:disable Standard.Category.Sniff -- for reasons.

    /**
     * Function comment.
     *
     * @return bool
     */
    public function func2() {}

}//end class

// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacing 2
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingBeforeFirst 2
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingAfterLast 2

echo 'just some code to let the below line test blank lines before';
echo 'something'; function testingFunctionNotOnOwnLine() {} echo 'somethingelse';
echo 'just some code to let the above line test blank lines after';

trait MyTrait {


    public function a(){}




    public function b(){}
    public function c(){}
}

$anon_class = new class() {
    public function a(){}

    protected function b(){}




    private function c(){}

};

// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacing 2
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingBeforeFirst 1
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingAfterLast 3

class MyClass
{

    public function a() {}

    public function b() {}

    public function c() {}

}

$bar = function () {
    {
        function a(){}
        function b(){}
        function c(){}
    }
};
class Foo {
    public function returnAnonymousClass() {
        return new class() {
            public function baz() {}
        };
    }

    public function bar() {
        function forbidden() {}
    }
}

if (function_exists('foo') === false) {
    function foo(){}
}

// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacing 0
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingBeforeFirst 0
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingAfterLast 0

interface OneBlankLineBeforeFirstFunctionClassInterface
{


    /** @return mixed */
    public function interfaceMethod();
}

// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacing 1
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingBeforeFirst 0
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingAfterLast 0

class MyClass
{

    // phpcs:disable Stnd.Cat.Sniff -- For reasons.

    /**
     * Description.
     */
    public function a() {}

    /**
     * Description.
     */
    public function b() {}

    /**
     * Description.
     */
    public function c() {}

    // phpcs:enable
}

class MyClass
{

    // Some unrelated comment

    /**
     * Description.
     */
    public function a() {}

    /**
     * Description.
     */
    public function b() {}

    /**
     * Description.
     */
    public function c() {}

    // function d() {}
}

class ClassWithAttributes
{

    public #[Attribute1]
    #[Attribute2]
    function a() {}

    public #[Attribute3]
    function b() {}

    public #[Attribute4]
    function c() {}

    /**
     * Description.
     */
    public #[Attribute5]
    function d() {}

    /**
     * Description.
     */
    public #[Attribute6]
    #[Attribute7]
    function e() {}

    public #[Attribute8]
    #[Attribute9]
    function f() {}

}

// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacing 2
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingBeforeFirst 2
// phpcs:set Squiz.WhiteSpace.FunctionSpacing spacingAfterLast 2
