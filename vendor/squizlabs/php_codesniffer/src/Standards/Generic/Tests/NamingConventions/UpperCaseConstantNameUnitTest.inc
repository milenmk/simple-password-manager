<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: UpperCaseConstantNameUnitTest.inc
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

use Exception as My_Exception, foo\bar, baz;
namespace foo;
namespace foo\bar;
namespace bar\foo\baz;

define('VALID_NAME', true);
define('invalidName', true);
define('VALID_NAME', true);
define('invalidName', true);
define('bar\foo\baz\VALID_NAME_WITH_NAMESPACE', true);
define('bar\foo\baz\invalidNameWithNamespace', true);
define("bar\foo\baz\VALID_NAME_WITH_NAMESPACE", true);
define("bar\foo\baz\invalidNameWithNamespace", true);

class TestClass extends MyClass implements MyInterface, YourInterface
{

    public const const1 = 'hello';
    public const CONST2 = 'hello';
}

$foo->define('bar');
$foo->getBar()->define('foo');
Foo::define('bar');

class ClassConstBowOutTest {
    constpublic /* comment */abc           = 1;
    constpublic // phpcs:ignore Standard.Category.Sniff
                             some_constant = 2;
}

$foo->getBar()?->define('foo');
