<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ClosingDeclarationCommentUnitTest.inc
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

function __construct()
{
}//end __construct()

function myFunction()
{
}//end myFunction()

function ourFunction()
{
}//end ourFunction

function yourFunction()
{
}//end myFunction()

class TestClass
{

    public function __construct() {}//end __construct()

    public function myFunction() {}//end myFunction()

    public function yourFunction() {}//end myFunction()

}//end class

abstract class TestClass
{

    public abstract function myFunction();

    public function ourFunction() {}//end myFunction()

    public function yourFunction() {}//end yourFunction()

}//end class

interface TestClass
{

    public function myFunction();

    public function ourFunction();

    public function yourFunction();

}//end interface

class TestClass
{
}

abstract class TestClass
{
}

interface TestClass
{
}

class MyClass
{
    public function myFunction();
}//end class

// Closures don't need end comments.
echo preg_replace_callback('~-([a-z])~', function ($match) { return strtoupper($match[1]); }, 'hello-world');

class TestClass
{
}
//end class

enum MissingClosingComment {
}

enum HasClosingComment {
}//end enum
